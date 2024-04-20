<!DOCTYPE html >
<html>
	<head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Comparison Universities</title>
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
                        <input class="form-control mr-2 search-input" name="university_name_1" placeholder="Enter the first university" value="<?php echo isset($_GET['university_name_1']) ? htmlspecialchars($_GET['university_name_1']) : ""; ?>">
                        <input class="form-control mr-2 search-input" name="university_name_2" placeholder="Enter the second university" value="<?php echo isset($_GET['university_name_2']) ? htmlspecialchars($_GET['university_name_2']) : ""; ?>">
                        <input class="form-control mr-2 search-input" name="year" placeholder="Enter a year" value="<?php echo isset($_GET['year']) ? htmlspecialchars($_GET['year']) : ""; ?>">
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
                case "rank_order":
                    $select_columns = "u.name, v.name_etat, c.rank_order";
                    break;
                case"scores_teaching":
                    $select_columns= "u.name, v.name_etat, c.scores_teaching";
                    break;
                case "scores_international_outlook":
                    $select_columns = "u.name, v.name_etat, c.scores_international_outlook";
                    break;
                case"scores":
                    $select_columns= "u.name, v.name_etat, (c.scores_teaching + c.scores_research + c.scores_citations + c.scores_industry_income + c.scores_international_outlook + c.stats_number_students + c.stats_pc_intl_students + c.stats_student_staff_ratio) / 8 AS average_score";
                    break;
            }

            if ($criteria === "scores_teaching" || $criteria === "scores_international_outlook") {
                $limit = "LIMIT 25";
            } else {
                $limit = ""; // Sinon, ne pas utiliser de limite
            }

            $query = "SELECT $select_columns
            FROM universite u
            JOIN etre e ON e.id_universite = u.id_universite
            JOIN ville v ON u.id_ville = v.id_ville
            JOIN classement c ON e.id_classement = c.id_classement
            WHERE c.annee = :annee
            ORDER BY " .($criteria === "scores" ? "average_score" : "c.$criteria")." DESC ";

            $result = $bdd->prepare($query);
            $result->bindValue(':annee', $annee, PDO::PARAM_STR);
            $result->execute();

            $data = array();
            if ($result !== false) {
                if ($result->rowCount() > 0){
                    while($row = $result->fetch(PDO::FETCH_ASSOC)){
                        if ($criteria === "scores") {
                            // Utilisez la moyenne calculée comme valeur pour "criteria"
                            $data[] = array("name" => $row["name"], "state" => $row["name_etat"], "criteria" => $row["average_score"]);
                        } else {
                            $data[] = array("name" => $row["name"], "state" => $row["name_etat"], "criteria"=> $row[$criteria]);
                    }
                }
            }
        }

            
;           return $data;
        }

        $university_names = fetch_data(2023, "rank_order");
        $scores_teaching = fetch_data(2023, "scores_teaching");
        $scores_international_outlook = fetch_data(2023, "scores_international_outlook");
        $scores = fetch_data(2023, "scores");
        
    ?>

        <h1> Comparisons by rank order</h1>
        <canvas id="chart" width="100" height="50"></canvas>

        <h1> 25 best scores teaching among universities </h1>  
        <canvas id="25_best_Universities_scores_teaching" width="50" height="50"></canvas>

        <h1> 25 best scores international look among universities </h1>         
        <canvas id="25_best_Universities_scores_international_outlook" width="50" height="50"></canvas>

        <h1> 25 best scores among universities </h1>         
        <canvas id="25_best_Universities_scores" width="50" height="50"></canvas>

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
                const data = <?php echo json_encode($university_names); ?>;
                const states = [...new Set(data.map(entry => entry.state))];

                const ctx = document.getElementById('chart');

                const datasets = states.map((state, index) => {
                    const universitiesInState = data.filter(entry => entry.state === state);
                    const xValues = universitiesInState.map(entry => entry.scores_teaching); // Criteria for x-axis
                    const yValues = universitiesInState.map(entry => entry.scores_international); // Criteria for y-axis
                    const bubbleSizes = new Array(xValues.length).fill(10); // Default bubble size

                    return {
                        label: state,
                        data: xValues.map((x, i) => ({ x, y: yValues[i], r: bubbleSizes[i] })),
                        backgroundColor: 'rgba(255, 206, 86, 0.2)',
                        borderColor: 'rgba(255, 206, 86, 1)',
                        borderWidth: 1
                    };
                });

                const universitiesInState = data.filter(entry => entry.state === states[0]);
                const bubbleSizes = new Array(universitiesInState.length).fill(10);
                        
                new Chart(ctx, {
                    type: 'scatter',
                    data: {
                        labels: universitiesInState.map(entry => entry.name),
                        datasets: [{   
                            label: "Universities' rank order along years",
                            data: universitiesInState.map((entry, i) => ({ x: entry.scores_teaching, y: entry.scores_international_outlook, r: bubbleSizes[i] })),
                            fill : false,
                            backgroundColor: 'rgba(255, 206, 86, 0.2)', 
                            borderColor: 'rgba(255, 206, 86, 1)',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        scales:{
                            x: {
                                type: 'linear',
                                position: 'bottom',
                                title: {
                                    display: true,
                                    text: 'Scores Teaching'
                                }
                            },
                            y:{   
                                type: 'linear',
                                position: 'left',
                                title: {
                                    display: true,
                                    text: 'Scores International Outlook'
                                } 
                               }
                            },
                        plugins: {
                            tooltip: {
                                callbacks: {
                                    label: (context) => {
                                        const universityName = data[context.dataIndex].name;
                                        return universityName;
                                    }
                                }
                            }
                        }
                    }
                });
                                                
                    
            }

            async function chartPie(data, title, canvasId){
                const totalUniversities = data.reduce((total, entry) => total + entry.criteria, 0);
                const percentages = data.map(entry => ({
                    label: `${entry.name} (${((entry.criteria / totalUniversities) * 100).toFixed(2)}%)`,
                    value: entry.criteria
                }));

                const ctxPie = document.getElementById(canvasId).getContext('2d');
                const viridisColors = chroma.scale('viridis').colors(data.length);

                new Chart(ctxPie, {
                    type: 'pie',
                    data: {
                        labels: percentages.map(entry => entry.label),
                        datasets: [{
                            label: title,
                            data: percentages.map(entry => entry.value),
                            backgroundColor: viridisColors,
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        tooltips: {
                            callbacks: {
                                label: function (tooltipItem, data) {
                                    const dataset = data.datasets[tooltipItem.datasetIndex];
                                    const percent = Math.round((dataset.data[tooltipItem.index] / dataset._meta[Object.keys(dataset._meta)[0]].total) * 100);
                                    return `${data.labels[tooltipItem.index]}: ${percent}%`;
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

                var teaching_data = <?php echo json_encode($scores_teaching); ?>;
                chartPie(teaching_data, "25_best_scores_teaching", "25_best_Universities_scores_teaching");
                
                var international_outlook_data = <?php echo json_encode($scores_international_outlook); ?>;
                chartPie(international_outlook_data, "25_best_scores_international_outlook", "25_best_Universities_scores_international_outlook");

                const scoresData = <?php echo json_encode($scores); ?>;
                var intervals = calculateIntervals(scoresData, 5);
                generatePieChart(intervals, 'Distribution of Universities by Score Intervals', 'scoresPieChart');


                chartPie(scoresData, "25 best scores", "25_best_Universities_scores");

            });

    </script>
</body>
</html>
    