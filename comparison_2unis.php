<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">        
    <link rel="stylesheet" type="text/css" href="menu.css">
    <title>Radar Chart Example</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
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
    </style>
</head>
<body>
    <?php
        include "menu_bar.html";
    ?>

    <div class="container mt-5">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <form id="universityForm" class="form-inline justify-content-center">
                    <input class="form-control mr-2 search-input" type="text" name="university1" placeholder="First University" required>
                    <input class="form-control mr-2 search-input" type="text" name="university2" placeholder="Second University" required>
                    <input class="form-control mr-2 search-input" type="number" name="year" placeholder="Year" value="<?php echo date('Y'); ?>" required>
                    <button type="submit" class="btn btn-primary search-button">Compare</button>
                </form>
            </div>
        </div>

        <h2 class="text-center mt-5">Scores Comparison</h2>
        <canvas id="radarChart"></canvas>

        <h2 class="text-center mt-5">Rank Evolution</h2>
        <canvas id="lineChart"></canvas>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        function updateCharts(university1, university2, year) {
            fetchChartData('scores.php', university1, university2, year)
                .then(data => createRadarChart(data))
                .catch(error => console.error('Error fetching scores:', error));
            

            fetchChartData('rank.php', university1, university2, year)
                .then(data =>{
                    console.log('Data received:', data);
                    createLineChart(data);
                })
                .catch(error => console.error('Error fetching ranks:', error));
                }

        function fetchChartData(url, university1, university2, year) {
            return fetch(`${url}?university1=${encodeURIComponent(university1)}&university2=${encodeURIComponent(university2)}&year=${encodeURIComponent(year)}`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                });
        }
        
        function createLineChart(data) {
            const ctx = document.getElementById('lineChart').getContext('2d');
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
            new Chart(ctx, {
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
        function createRadarChart(data) {
            const ctx = document.getElementById('radarChart').getContext('2d');
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
            new Chart(ctx, {
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

        document.getElementById('universityForm').addEventListener('submit', function(e) {
            e.preventDefault();

            const university1 = document.querySelector('[name="university1"]').value;
            const university2 = document.querySelector('[name="university2"]').value;
            const year = document.querySelector('[name="year"]').value;

            fetch(`fetch_data.php?university1=${encodeURIComponent(university1)}&university2=${encodeURIComponent(university2)}&year=${encodeURIComponent(year)}`)
                .then(response => response.json())
                .then(data => {
                    createRadarChart(data);
                    createLineChart(data);
                })
                .catch(error => console.error('Error fetching data:', error));
        });
    </script>
    <footer>
        Copyright © 2023 UniDiscover
    </footer>
</body>
</html>