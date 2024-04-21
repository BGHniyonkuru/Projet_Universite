<?php
session_start();
?>
<!DOCTYPE html >
<html>
	<head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Universities comparison</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.0/chart.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/chroma-js@2.1.0/chroma.min.js"></script>

        <style>
            .search-form {
                display: flex;
                align-items: center;
                flex-direction: row;
            }

            .search-input {
                flex: 1;
                margin-right: 10px;
                padding: 5px;
                border: 1px solid #ccc;
                border-radius: 5px;
            }

            .search-button {
                height: 60px;
                width: 60px;
                padding: 5px 15px;
                background-color: white;
                color: #fff;
                border: none;
                border-radius: 50%;
                cursor: pointer;
            }

            @media screen and (max-width: 768px) {
            .search-form {
                flex-direction: column;
            }

            .search-input {
                width: 100%; 
                margin-right: 0;
            }
            }
        </style>
    
	</head>
	<body>
        <?php
            include "menu_bar.html";
        ?>

        <div class="container mt-3">
            <div class="row">
                <div class="col-md-6 mx-auto">
                    <form class="search-form" action="comparison_2unis.php" method="get">
                        <input class="form-control mr-2 search-input" type="text" name="university1" placeholder="First university" value="<?php echo isset($_GET['university_name_1']) ? htmlspecialchars($_GET['university_name_1']) : ""; ?>">
                        <input class="form-control mr-2 search-input" type="text" name="university2" placeholder="Second university" value="<?php echo isset($_GET['university_name_2']) ? htmlspecialchars($_GET['university_name_2']) : ""; ?>">
                        <input class="form-control mr-2 search-input" type="number" name="year" placeholder="Year" value="<?php echo isset($_GET['year']) ? htmlspecialchars($_GET['year']) : ""; ?>">
                        <button class="btn btn-primary search-button" type="submit"><img src="assets/Images/search.png" alt="Search"></button>
                    </form>
                </div>
            </div>
        </div>




        <?php
        require_once("bd.php");
        function fetch_data($annee, $criteria){
            $bdd = getBD();
            $select_columns = "";

            switch($criteria){
                case "scatter":
                    $select_columns = "u.name as university_name, v.name_etat as state, c.scores_teaching, c.scores_international_outlook, rank_order";
                    break;
                case"scores":
                    $select_columns= "u.name as university_name, v.name_etat as state, (c.scores_teaching + c.scores_research + c.scores_citations + c.scores_industry_income + c.scores_international_outlook + c.stats_number_students + c.stats_pc_intl_students + c.stats_student_staff_ratio) / 8 AS average_score";
                    break;
            }

            $query = "SELECT $select_columns
            FROM universite u
            JOIN etre e ON e.id_universite = u.id_universite
            JOIN ville v ON u.id_ville = v.id_ville
            JOIN classement c ON e.id_classement = c.id_classement
            WHERE c.annee = :annee";

            $result = $bdd->prepare($query);
            $result->bindValue(':annee', $annee, PDO::PARAM_STR);
            $result->execute();

            $data = array();
            
            while($row = $result->fetch(PDO::FETCH_ASSOC)){
                $data[] = $row; // Simplified data addition
            }
            return $data;
        }
        
        $scatterData = fetch_data(2023, "scatter");
        $scores = fetch_data(2023, "scores");
        
    ?>

        <h1> Comparisons by rank order</h1>
        <canvas id="chart" width="100" height="50"></canvas>

        <h1>Composition</h1>
        <canvas id="scoresPieChart" width="50" height="50"></canvas>

        <footer>
            Copyright © 2023 UniDiscover
        </footer> 
        

        <script> 

            function calculateIntervals(data, numIntervals) {
                const sortedData = data.sort((a, b) => a.criteria - b.criteria);
                const intervalSize = Math.ceil(sortedData.length / numIntervals);
                const intervals = {};
                for (let i = 0; i < numIntervals; i++) {
                    const startIndex = i * intervalSize;
                    const endIndex = Math.min(startIndex + intervalSize - 1, sortedData.length - 1);
                    const key = `Interval ${i + 1}: ${sortedData[startIndex].criteria} to ${sortedData[endIndex].criteria}`;
                    intervals[key] = sortedData.slice(startIndex, endIndex + 1).length; // Store the count of universities in this interval
                }
                return intervals;
            }

            function groupDataByInterval(data, intervals) {
                var groupedData = {};

                // Initialize grouped data array
                for (var key in intervals) {
                    groupedData[key] = [];
                }

                // Loop through the data and assign each entry to an interval
                data.forEach(function(entry) {
                    var score = entry.criteria;
                    for (var key in intervals) {
                        var interval = intervals[key];
                        if (score >= interval[0] && score <= interval[1]) {
                            groupedData[key].push(entry);
                            break;
                        }
                    }
                });

                return groupedData;
            }

              
            async function chartIt(){
                const data = <?php echo json_encode($scatterData); ?>;
                const ctx = document.getElementById('chart').getContext('2d');
                        
                new Chart(ctx, {
                    type: 'scatter',
                    data: {
                        datasets: [{
                            label: 'Teaching vs International Outlook',
                            data: data.map(item => ({
                                x: item.scores_teaching,
                                y: item.scores_international_outlook,
                                r: 10,
                                label: item.university_name + ' (' + item.state + ') : The rank :' + item.rank_order
                            })),
                            backgroundColor: 'rgba(255, 206, 86, 0.2)', 
                            borderColor: 'rgba(255, 206, 86, 1)',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        scales: {
                            x: {
                                title: {
                                    display: true,
                                    text: 'Teaching Scores'
                                }
                            },
                            y: {
                                title: {
                                    display: true,
                                    text: 'International Outlook Scores'
                                }
                            }
                        },
                        plugins: {
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        return context.raw.label;
                                    }
                                }
                            }
                        }
                    }
                });
                                                
                    
            }            
            
            function generatePieChart(intervals, title, canvasId) {
                const ctx = document.getElementById(canvasId).getContext('2d');
                const dataPoints = Object.values(intervals);
                const total = dataPoints.reduce((acc, curr) => acc + curr, 0);

                const data = {
                    labels: Object.keys(intervals),
                    datasets: [{
                        data: dataPoints,
                        backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56', '#E7E9ED', '#4BC0C0'],
                        hoverBackgroundColor: ['#FF6384', '#36A2EB', '#FFCE56', '#E7E9ED', '#4BC0C0']
                    }]
                };
                console.log("Data Points: ", dataPoints);
                console.log("Total: ", total);
                new Chart(ctx, {
                    type: 'pie',
                    data: data,
                    options: {
                        responsive: true,
                        tooltips: {
                            enabled: true,
                            mode: 'single',
                            callbacks: {
                                label: function(tooltipItem, data) {
                                    const label = data.labels[tooltipItem.index];
                                    const value = data.datasets[tooltipItem.datasetIndex].data[tooltipItem.index];
                                    const percentage = ((value/total) * 100).toFixed(2); // Calculate the percentage
                                    return '${label}: ${value} (${percentage}%)';
                                }
                            }
                        },
                        title: {
                            display: true,
                            text: title
                        },
                        legend: {
                            position: 'bottom',
                        }
                    }
                });
            }   
        

        

            document.addEventListener("DOMContentLoaded", function() {
                
                chartIt();

                const scoresData = <?php echo json_encode($scores); ?>;
                var intervals = calculateIntervals(scoresData, 5);
                generatePieChart(intervals, 'Distribution of Universities by Score Intervals', 'scoresPieChart');

            });

    </script>
</body>
</html>
    