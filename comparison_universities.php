<!DOCTYPE html >
<html>
	<head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link rel="stylesheet" type="text/css" href="assets/menu.css">
        <title>Comparison Universities</title>
        <script type="module" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.0/chart.min.js"></script>
	</head>
	<body>
        <?php
        require("bd.php");
        $menu_bar_content = file_get_contents("menu_bar.html");
        echo $menu_bar_content;

        function fetch_university_names($annee, $criteria){
            $bdd = getBD();
            $select_columns = "";

            switch($criteria){
                case "rank_order":
                    $select_columns = "u.name, c.rank_order";
                    break;
                case"scores_teaching":
                    $select_columns= "u.name, c.score_teaching";
                    break;
                case "scores_international_outlook":
                    $select_columns = "u.name, c.scores_international_outlook";
                    break;

            }

            $query = "SELECT $select_columns
            FROM universite u
            JOIN etre e ON e.id_universite = u.id_universite
            JOIN classement c ON e.id_classement = c.id_classement
            WHERE c.annee = :annee";

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

    $university_names = fetch_university_names(2023, "rank_order");
    ?>

        <h1> Comparisons by rank order</h1>
        <canvas id="chart" width="300" height="300"></canvas>
        

        <script>
            chartIt();
            
            async function chartIt(){
                const data = <?php echo json_encode($university_names); ?>;
                const xs = data.map(entry => entry.name);
                const ys = data.map(entry => entry.criteria);
                document.addEventListener("DOMContentLoaded", function(){
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
                                        callback: function(value, index, values){
                                            return value + "th";
                                        }
                                    }
                                }]
                            }
                        }
                        
                    });
                });
            }
        </script>

        <!-- 
        <h1> 25 best scores teaching among universities </h1>
        <h1> 25 best scores international look among universities </h1>    
        <div id="rank_order_graph"></div>
        async function  getData(){
                const xs = [];
                const ys = [];
                const response = await fetch('classement.csv');
                const data = await response.text();

                const table = data.split('\n').slice(1);
                table.forEach(row => {
                    const columns = row.split(',');
                    const year = columns[1];
                    xs.push(year);
                    const temp = columns[2];
                    ys.push(parseFloat(temp));
                    console.log(year, temp);
                });
                return {xs, ys};
            }
        <script>
            var xher = new XMLHttpRequest();
            xhr.open('GET', 'http://localhost:5000/visualization', true);
            xhr.onreadystatechange = function(){
                if (xhr.readyState === 4 && xhr.status === 200){
                    var data = JSON.parse(xhr.responseText);

                    Plotly.newPlot('graph', data);
                }
            };
            xhr.send();
        </script>
        <h1>Comparisons by acceptance rate</h1> -->
</body>
</html>