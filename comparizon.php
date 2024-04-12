<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">        
    <link rel="stylesheet" type="text/css" href="assets/menu.css">
    <title>Radar Chart Example</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <?php
    $menu_bar_content = file_get_contents("menu_bar.html");
    echo $menu_bar_content;
    ?>
    <canvas id="myChart" width="400" height="400"></canvas>

    <script>

    function fetchDataFromScoresPHP(url) {
        return fetch(url)
            .then(response => response.json())
            .catch(error => {
            console.error('Error fetching data from scores.php:', error);
            throw error;
            });
        }
    function createRadarChart(data) {
      // Extracting the values for the radar chart datasets
        const dataset1Data = Object.values(data[0]);
        const dataset2Data = Object.values(data[1]);

        // Define options for the radar chart
        const options = {
            scales: {
            r: {
                angleLines: {
                display: false
                },
                suggestedMin: 0,
                suggestedMax: 100
            }
            }
        };

        const chartData = {
        labels: [
            'scores_teaching',
            'scores_research',
            'scores_citations',
            'scores_industry_income',
            'scores_international_outlook',
            'stats_number_students',
            'stats_pc_intl_students',
            'stats_student_staff_ratio'
        ],
        datasets: [{
            label: 'My First University',
            data: dataset1Data,
            fill: true,
            backgroundColor: 'rgba(255, 99, 132, 0.2)',
            borderColor: 'rgb(255, 99, 132)',
            pointBackgroundColor: 'rgb(255, 99, 132)',
            pointBorderColor: '#fff',
            pointHoverBackgroundColor: '#fff',
            pointHoverBorderColor: 'rgb(255, 99, 132)'
        }, {
            label: 'My Second University',
            data: dataset2Data,
            fill: true,
            backgroundColor: 'rgba(54, 162, 235, 0.2)',
            borderColor: 'rgb(54, 162, 235)',
            pointBackgroundColor: 'rgb(54, 162, 235)',
            pointBorderColor: '#fff',
            pointHoverBackgroundColor: '#fff',
            pointHoverBorderColor: 'rgb(54, 162, 235)'
        }]
        };

        const ctx = document.getElementById('myChart').getContext('2d');
        const myChart = new Chart(ctx, {
            type: 'radar',
            data: chartData,
            options: options
        });
        }

        document.addEventListener('DOMContentLoaded', () => {
            fetchDataFromScoresPHP('http://localhost/projet_universite/scores.php?annee=2023&university_name_1=Harvard%20University&university_name_2=Yale%20University')
                .then(data => {
                    createRadarChart(data);
                })
                .catch(error => {
                    console.error('Error creating radar chart:', error);
                });
        });

        const options = {
        scales: {
            r: {
            angleLines: {
                display: false
            },
            suggestedMin: 0,
            suggestedMax: 100
            }
        }
        };
  </script>
</body>
</html>
