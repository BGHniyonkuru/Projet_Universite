<?php
    session_start();
    require_once("bd.php");
        function fetch_data($annee){
            $bdd = getBD();
        
            $query = "SELECT u.name as university_name, v.name_etat as state, c.scores_teaching, c.scores_international_outlook, rank_order
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
        
        $scatterData = fetch_data(2023);

        function fetch_universities() {
            $bdd = getBD();
            $query = "SELECT DISTINCT name FROM universite ORDER BY name ASC";
            $result = $bdd->query($query);
            $universities = $result->fetchAll(PDO::FETCH_ASSOC);
            return $universities;
        }
        
        $universities = fetch_universities();

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
            .body_graph_compare {
            max-width: 800px;
            min-height: 200px;
            margin: 20px auto;
            padding: 0px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 1);
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            align-items: center;
        }
            .graph-container {
                margin: 10px;
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

    
            body, html {
                margin: 0;
                padding: 0;
                height: 100%; /* Full height */
                background-color: #f0f2f5;
            }

            .bandeau {
                text-decoration: none;
                color: white;
            }

            #logo {
                margin-left: 130px;
                margin-top: 10px;
                height: 90px;
                width: 90px;
            }

            #logo2 {
                margin-left: 100px;
                margin-top: 5px;
                height: 50px;
                width: 50px;
            }

            #logo3 {
                margin-left: 10px;
                margin-top: 5px;
                height: 50px;
                width: 50px;
            }

            .container {
                height:100px;
                background-color: #3C3B6E;
                color: white;
                padding-top: 10px;
                padding-bottom: 10px;
                display: flex;
                justify-content: center;
                align-items: center;
                width: 100%;
                margin: 0;
                max-width: none;
            }

            .container > ul {
                position: relative;
                margin-top:30px;
                transform: translateY(-50%);	
                text-align: center;
                background-color:#3C3B6E;
                width:800px;
            }
            .container > ul > li{
                list-style-type: none;
                display: inline;
                margin-right: 50px;
                
            }
            li:hover{
                font-size: 20px;
            }

            .container ul li a {
                color: white;
                text-decoration: none;
            }
        </style>
    
	</head>
	<body>
        <div class="container">

        <a href= "accueil.php"><img id="logo" src="images/logo.png" alt="logo" ></a>

        <ul>
            <li><a class= "bandeau" href="compare.php">Compare</a></li>
            <li><a class= "bandeau" href="localisation.php">Map</a></li>
            <li><a class= "bandeau" href="prediction.html" >Predict</a></li>
            <li><a class= "bandeau" href="contact.php" >Contact</a></li>
            <li><a class= "bandeau" href="search_university.html" >Search</a></li>
        </ul>
        <a href= "favoris.php"><img id="logo2" src="images/favori.png" alt="logo"></a>
        <a href= "monCompte.php"><img id="logo3" src="images/monCompte.png" alt="logo"></a>
        </div>

        <div class="form-container mt-3">
            <div class="row">
                <div class="col-md-6 mx-auto">
                    <form class="search-form" action="#" method="GET" onsubmit="fetchAndDisplay(); return false;">
                        <select class="form-control mr-2 search-input" name="university1">
                            <option value="">Select First University</option>
                            <?php foreach($universities as $university): ?>
                                <option value="<?php echo htmlspecialchars($university['name']); ?>" <?php echo (isset($_GET['university1']) && $_GET['university1'] == $university['name']) ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($university['name']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <select class="form-control mr-2 search-input" name="university2">
                            <option value="">Select Second University</option>
                            <?php foreach($universities as $university): ?>
                                <option value="<?php echo htmlspecialchars($university['name']); ?>" <?php echo (isset($_GET['university2']) && $_GET['university2'] == $university['name']) ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($university['name']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>

                        <input class="form-control mr-2 search-input" type="number" name="year" placeholder="Year" value="<?php echo isset($_GET['year']) ? htmlspecialchars($_GET['year']) : ""; ?>">
                        <button class="btn btn-primary search-button" type="submit"><img src="images/search.png" alt="Search"></button>
                    </form>
                </div>
            </div>
        </div>
    

        <div class="body_graph_compare">
            <div class="graph-container">

                <h1> Comparisons by rank order</h1>
                <canvas id="chart" width="100" height="150"></canvas>
            </div>
        </div>

        <div class="body_graph_compare" style="display: none;" id="radarContainer">
            <div class="graph-container">
                <h2 class="text-center mt-5">Scores Comparison</h2>
                <canvas id="radarChart"></canvas>
            </div>
        </div>
        
        <div class="body_graph_compare" style="display: none;" id="lineContainer">
            <div class="graph-container">
                <h2 class="text-center mt-5">Rank Evolution</h2>
                <canvas id="lineChart"></canvas>
            </div>
        </div>
    
        <footer>
            Copyright © 2023 UniDiscover
        </footer> 
        

        <script>
        
            async function chartIt(initialData){
                const data = <?php echo json_encode($scatterData); ?>;
                const ctx = document.getElementById('chart').getContext('2d');
                        
                new Chart(ctx, {
                    type: 'scatter',
                    data: {
                        datasets: [{
                            label: 'Teaching vs International Outlook',
                            data: initialData.map(item => ({
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

            async function updateCharts(university1, university2, year) {
                const url = `fetch_data.php?university1=${encodeURIComponent(university1)}&university2=${encodeURIComponent(university2)}&year=${encodeURIComponent(year)}`;
                try {
                    const response = await fetch(url);
                    const data = await response.json();
                    createRadarChart(data);
                    createLineChart(data);
                    document.getElementById('radarContainer').style.display = 'block';
                    document.getElementById('lineContainer').style.display = 'block';
                } catch (error) {
                    console.error('Error fetching data:', error);
                }
            }

            async function fetchChartData(url, university1, university2, year) {
                const fetchUrl = `${url}?university1=${encodeURIComponent(university1)}&university2=${encodeURIComponent(university2)}&year=${encodeURIComponent(year)}`;
                try {
                    const response = await fetch(fetchUrl);
                    if (!response.ok) {
                        throw new Error(`HTTP error! Status: ${response.status}`);
                    }
                    return await response.json();
                } catch (error) {
                    console.error('Failed to fetch data:', error);
                    return null;  // You might want to handle this case explicitly in your calling function
                }
            }

            var radarChart;
            var lineChart;
              
            
            
            async function createLineChart(data) {
                const ctx = document.getElementById('lineChart').getContext('2d');
                if (window.lineChart) {
                    window.lineChart.destroy(); // Destroy the existing chart before creating a new one
                }
                const lineData = {
                    labels: data.ranks.reduce((acc, cur) => {
                        if (!acc.includes(cur.annee)) {
                            acc.push(cur.annee);
                        }
                        return acc;
                    }, []),
                    datasets: data.ranks.reduce((result, rank) => {
                        let found = result.find(r => r.label === rank.university_name);
                        if (!found) {
                            found = {
                                label: rank.university_name,
                                data: [],
                                fill: false,
                                backgroundColor: `rgba(${Math.floor(Math.random() * 255)}, ${Math.floor(Math.random() * 255)}, ${Math.floor(Math.random() * 255)}, 0.2)`,
                                borderColor: `rgba(${Math.floor(Math.random() * 255)}, ${Math.floor(Math.random() * 255)}, ${Math.floor(Math.random() * 255)}, 1)`,
                                pointBackgroundColor: `rgba(${Math.floor(Math.random() * 255)}, ${Math.floor(Math.random() * 255)}, ${Math.floor(Math.random() * 255)}, 1)`,
                            };
                            result.push(found);
                        }
                        found.data.push(rank.rank_order);
                        return result;
                    }, [])
                };
                window.lineChart = new Chart(ctx, {
                    type: 'line',
                    data: lineData,
                    options: {
                        scales: {
                            y: {
                                reverse: false,  // because a lower rank is better
                                title: {
                                    display: true,
                                    text: 'University Rank'
                                }
                            }
                        }
                    }
                });
            }
            async function createRadarChart(data) {
                const ctx = document.getElementById('radarChart').getContext('2d');
                if (window.radarChart) {
                    window.radarChart.destroy(); // Destroy the existing chart before creating a new one
                }
                const radarData = {
                    labels: ['Teaching', 'Research', 'Citations', 'Industry Income', 'International Outlook'],
                    datasets: data.scores.map(univ => ({
                        label: univ.university_name,
                        data: [
                            univ.scores_teaching,
                            univ.scores_research,
                            univ.scores_citations,
                            univ.scores_industry_income,
                            univ.scores_international_outlook
                        ],
                        fill: true,
                        backgroundColor: `rgba(${Math.floor(Math.random() * 255)}, ${Math.floor(Math.random() * 255)}, ${Math.floor(Math.random() * 255)}, 0.2)`,
                        borderColor: `rgba(${Math.floor(Math.random() * 255)}, ${Math.floor(Math.random() * 255)}, ${Math.floor(Math.random() * 255)}, 1)`,
                        pointBackgroundColor: `rgba(${Math.floor(Math.random() * 255)}, ${Math.floor(Math.random() * 255)}, ${Math.floor(Math.random() * 255)}, 1)`,
                    }))
                };

                window.radarChart =new Chart(ctx, {
                    type: 'radar',
                    data: radarData,
                    options: {
                        elements: {
                            line: {
                                tension: 0.2
                            }
                        }
                    }
                });
            }

            function handleFormSubmit() {
                const university1 = document.querySelector('[name="university1"]').value;
                const university2 = document.querySelector('[name="university2"]').value;
                const year = document.querySelector('[name="year"]').value;
                updateCharts(university1, university2, year);
                return false;  // Prevent form submission
            }

                  

            document.querySelector('.search-form').addEventListener('submit', function(e){
                e.preventDefault();
                const university1 = document.querySelector('[name="university1"]').value;
                const university2 = document.querySelector('[name="university2"]').value;
                const year = document.querySelector('[name="year"]').value;
                updateCharts(university1, university2, year);
            });

            chartIt(<?php echo json_encode($scatterData); ?>);

        

    </script>
</body>
</html>  