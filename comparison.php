<!DOCTYPE html >
<html>
	<head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link rel="stylesheet" type="text/css" href="assets/menu.css">
        <title>Comparison Universities</title>
        <script type="module" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.0/chart.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/chroma-js@2.1.0/chroma.min.js"></script>
	</head>
	<body>
        <?php
        
        $menu_bar_content = file_get_contents("menu_bar.html");
        echo $menu_bar_content;

        function fetch_data($annee, $criteria){
            require_once("bd.php");
            $bdd = getBD();
            $select_columns = "";

            switch($criteria){
                case "rank_order":
                    $select_columns = "u.name, c.rank_order";
                    break;
                case"scores_teaching":
                    $select_columns= "u.name, c.scores_teaching";
                    break;
                case "scores_international_outlook":
                    $select_columns = "u.name, c.scores_international_outlook";
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
            JOIN classement c ON e.id_classement = c.id_classement
            WHERE c.annee = :annee
            ORDER BY c.$criteria DESC $limit";

            $result = $bdd->prepare($query);
            $result->bindValue(':annee', $annee, PDO::PARAM_STR);
            $result->execute();

            $data = array();
            if ($result !== false) {
                if ($result->rowCount() > 0){
                    while($row = $result->fetch(PDO::FETCH_ASSOC)){
                        $data[] = array("name" => $row["name"], "criteria"=> $row[$criteria]);
                    }
                }
            }
            return $data;
        }

    $university_names = fetch_data(2023, "rank_order");
    $scores_teaching = fetch_data(2023, "scores_teaching");
    $scores_international_outlook = fetch_data(2023, "scores_international_outlook");

    ?>

        <h1> Comparisons by rank order</h1>
        <canvas id="chart" width="100" height="50"></canvas>

        <h1> 25 best scores teaching among universities </h1>  
        <canvas id="25 best Universities' scores_teaching" width="50" height="50"></canvas>

        <h1> 25 best scores international look among universities </h1>         
        <canvas id="25 best Universities' scores_international_outlook" width="50" height="50"></canvas>

        <h1>Comparisons by acceptance rate</h1>
        

        <script>       
            async function chartIt(){
                const data = <?php echo json_encode($university_names); ?>;
                const xs = data.map(entry => entry.name);
                const ys = data.map(entry => entry.criteria);
                const ctx = document.getElementById('chart');
                    
                    new Chart(ctx, {
                        type: 'line',
                        data: {
                            labels: xs,
                            datasets: [{
                                label: "Universities' rank order along years",
                                data: ys,
                                fill : false,
                                backgroundColor: 'rgba(255, 206, 86, 0.2)', 
                                borderColor: 'rgba(255, 206, 86, 1)',
                                borderWidth: 1
                            }]
                        },
                        options: {
                            scales:{
                                yAxes:[{
                                    ticks: {
                                        beginAtZero: true, 
                                        suggestedMin: 0,   
                                        suggestedMax: 100   
                                        }
                                    }]
                                }
                            }
                        })
                        
                    
            }

            async function chartPie(data, title, canvasId){
                const labels = data.map(entry => entry.name);
                const scores = data.map(entry => entry.criteria);
                const ctxPie = document.getElementById(canvasId).getContext('2d');
                const viridisColors = chroma.scale('viridis').colors(25);

                new Chart(ctxPie, {
                    type: 'pie',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: title,
                            data: scores,
                            backgroundColor: viridisColors,        
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        tooltips: {
                            callbacks: {
                                label: function(context) {
                                    var label = context.label || '';
                                    if (label) {
                                        label += ': ';
                                    }
                                    label += context.formattedValue;
                                    return label;
                                },
                                title: function(tooltipItem, data) {
                                    return data.labels[tooltipItem[0].index];
                                }
                            }
                        }
                    }
                });
            }
            document.addEventListener("DOMContentLoaded", function() {
                
                chartIt();

                var teaching_data = <?php echo json_encode($scores_teaching); ?>;
                chartPie(teaching_data, "25_best_scores_teaching", "25 best Universities' scores_teaching");
                
                var international_outlook_data = <?php echo json_encode($scores_international_outlook); ?>;
                chartPie(international_outlook_data, "25_best_scores_international_outlook", "25 best Universities' scores_international_outlook");
        


            });

        </script>

</body>
</html>
    