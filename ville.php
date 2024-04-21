<?php
session_start();

    // Établir une connexion à la base de données
    $pdo = new PDO('mysql:host=localhost;dbname=projet_universite', 'root', '');

    // Requête pour récupérer les noms des villes
    $queryVilles = "SELECT distinct(ville.name),ville.id_ville,name_etat FROM avoir, ville, crime where avoir.id_ville=ville.id_ville and ville.id_ville=crime.id_ville";
    $resultVilles = $pdo->query($queryVilles);
    $villes = $resultVilles->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comparaison des villes</title>
    <link rel="stylesheet" href="style.css" type="text/css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            
            margin: 0;
            padding: 0;
            background-color: #FAF7F2;
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

        .bandeau {
            text-decoration: none;
            color: white;
        }

        #logo {
            margin-left: 130px;
            margin-top: 10px;
            height: 100px;
            width: 100px;
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
        h1 {
            text-align: center;
            font-size: 28px;
            color: #333;
            padding-top: 20px;
            font-weight: bold;
        }
        h2 {
            text-align: center;
            margin-top: 20px;
            font-size: 20px;
        }
        .search-box {
            flex-grow: 1;
            margin: 5px;
        }
        .search-container {
            display: flex;
            justify-content: space-around;
            flex-direction: row;
            width: 100%;
            flex-wrap: wrap;
            justify-content: center;
            align-items: center;
        }
        .form-label, {
            flex: 1;
            margin: 5px;
        }
        .form-select{
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
        }

        button{
            display: inline-block;
            margin-top: 25px;
            margin-bottom: 0px;
            padding: 10px 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
            border-radius: 50%; /* Valeur qui rend le bouton oval */
            background-color: #3C3B6E; /* Couleur de fond */
            color:white;
            text-align: center;
            font-size: 16px;
            border:none;
        }
        .barre{
            margin: 10px;
            border-radius: 10px;
            
        }
        #category{
            width: 200px;
        }
        .section{
            background-color: #F9F3EA;
            min-height: 10px;
            padding: 10px;
        }
        #comparisonComment{
            text-align:center; 
            font-style:italic;
            
        }
        .comparison-table table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
        }

        .comparison-table th, .comparison-table td {
            text-align: left;
            padding: 8px;
            border-bottom: 1px solid #ddd;
        }

        .comparison-table th {
            background-color: #f2f2f2;
        }

        .comparison-table td {
            background-color: #fdfdfd;
        }

        .comparison-table tr:hover {
            background-color: #f1f1f1;
        }
        footer{
            margin-top: 350px;
            background-color: #ec1029;
            color: white;
            text-align: center;
            position: static;
            bottom: 0;
            width: 100%;
        }

    </style>
</head>
<body>
    <!-- Bandeau en haut de l'écran -->
    <div class="container">
        <a href= "accueil.php"><img id="logo" src="http://localhost/Projet/images/logo.png" alt="logo"></a>
        <ul>
            <li><a class= "bandeau" href="compare.php">Compare</a></li>
            <li><a class= "bandeau" href="localisation.php">Map</a></li>
            <li><a class= "bandeau" href="predire.php" >Predict</a></li>
            <li><a class= "bandeau" href="contact.php" >Contact</a></li>
            <li><a class= "bandeau" href="search.php" >Search</a></li>
        </ul>
        <a href= "favoris.php"><img id="logo2" src="http://localhost/Projet/images/favori.png" alt="logo"></a>
        <a href= "monCompte.php"><img id="logo3" src="http://localhost/Projet/images/monCompte.png" alt="logo"></a>
    </div>

    <h1>City comparison</h1>
    <div class="search-container">
        <form method="post" class="search-container">
            <div class='barre'>
                <label for="ville1" class="form-label">First city:</label>
                <select class="form-select" name="ville1" id="ville1" required>
                    <option value="">Choose a city</option>
                    <?php foreach ($villes as $ville) : ?>
                        <option value="<?= $ville['id_ville'] ?>"><?= $ville['name']." - ".$ville['name_etat']?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class='barre'>
                <label for="ville2" class="form-label">Second city:</label>
                <select class="form-select" name="ville2" id="ville2" required>
                    <option value="">Choose a city</option>
                    <?php foreach ($villes as $ville) : ?>
                        <option value="<?= $ville['id_ville'] ?>"><?= $ville['name']." - ".$ville['name_etat'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <button type="submit" class=".oval-button">Compare</button>
        </form>
    </div>

    <?php  if ($_SERVER["REQUEST_METHOD"] == "POST") { ?>

    <div class="body_graph_compare">
        <div class="graph-container">
            <h2>Total cost of living</h2>
            <canvas id="totalCosts"></canvas>
        </div>
    </div>
    <?php
        // Traitement du formulaire
       
            $ville1_id = $_POST["ville1"] ?? '';
            $ville2_id = $_POST["ville2"] ?? '';
            // Requête pour le premier graphique - moyenne des coûts de vie des deux villes
            $queryCoutDeVie = "SELECT ville.name,(Meal + MealFor2_people + McMeal + Capuccino + CokePepsi + Milk + FreshBread + Rice + Eggs + LocalCheese + ChickenFillets + BeefRound + Apples + Banana + Oranges + Tomato + Potato + Onion + Lettuce + Water + DomesticBeer + Cigarettes20Pack + OneWayTicket + MonthlyPass + TaxiStart + TaxiUnKm + Gasoline + BasicFor85m2 + OneMminPrepaid + Internet + FitnessClubMonthly + TennisCourtRentOneH + Cinema + OneJeansLevis + SummerDress + PairOfNike + PairOfMenShoes + AppartmentOneBedroomCity + AppartmentOneBedroomOutsideCentre + AppartmentThreeBedroomsCity + AppartmentThreeBedroomsOutsideCentre + PriceSquareMeterBuyApartmentCity + PricePerSquareMeterBuyApartmentOutside + AverageMonthlyNetSalary + InterestRate) AS Total_cost
                                FROM cout_de_vie
                                INNER JOIN avoir ON cout_de_vie.id_cout = avoir.id_cout
                                INNER JOIN ville ON ville.id_ville = avoir.id_ville
                                WHERE avoir.id_ville IN (?, ?)
                                GROUP BY ville.name";
            $stmt = $pdo->prepare($queryCoutDeVie);
            $stmt->execute([$ville1_id, $ville2_id]);
            $coutDeVieData = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Comparing total cost of living
            $totalCostsComment = "";
            if (!empty($coutDeVieData) && count($coutDeVieData) == 2) {
                if ($coutDeVieData[0]['Total_cost'] > $coutDeVieData[1]['Total_cost']) {
                    $totalCostsComment = $coutDeVieData[0]['name'] . " has a higher total cost of living compared to " . $coutDeVieData[1]['name'];
                } else if ($coutDeVieData[0]['Total_cost'] < $coutDeVieData[1]['Total_cost']) {
                    $totalCostsComment = $coutDeVieData[1]['name'] . " has a higher total cost of living compared to " . $coutDeVieData[0]['name'];
                } else {
                    $totalCostsComment = "Both cities have similar total costs of living.";
                }
            }
    ?>

    <div class="section">
        <p id="comparisonComment"><?=$totalCostsComment;?></p>
    </div>

    <div class="body_graph_compare">
        <div class="graph-container">
            <h2>Crime infos</h2>
            <canvas id="crimeStats"></canvas>
        </div>
    </div>

    <?php
            // Requête pour le deuxième graphique - comparaison des attributs de la table "crime"
            $queryCrimeAttributes = "SELECT ville.name, sum(crime.victims_killed +crime.victims_injured + crime.suspects_killed + crime.suspects_injured + crime.suspects_arrested) as crime_indicator 
                                    FROM `crime`,ville 
                                    where crime.id_ville=ville.id_ville and crime.id_ville IN (?, ?) 
                                    GROUP BY ville.name";
            $stmt = $pdo->prepare($queryCrimeAttributes);
            $stmt->execute([$ville1_id, $ville2_id]);
            $crimeData = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Préparation des données pour le graphique
            $crimeStatsData = ['labels' => [], 'data' => []];
            foreach ($crimeData as $row) {
                $crimeStatsData['labels'][] = $row['name'];
                $crimeStatsData['data'][] = $row['crime_indicator'];
            }

            $comparisonComment = "";
            if (!empty($crimeStatsData['data']) && count($crimeStatsData['data']) == 2) {
                if ($crimeStatsData['data'][0] > $crimeStatsData['data'][1]) {
                    $comparisonComment = $crimeStatsData['labels'][0] . " has a higher crime indicator compared to " . $crimeStatsData['labels'][1];
                } else if ($crimeStatsData['data'][0] < $crimeStatsData['data'][1]) {
                    $comparisonComment = $crimeStatsData['labels'][1] . " has a higher crime indicator compared to " . $crimeStatsData['labels'][0];
                } else {
                    $comparisonComment = "Both cities have similar crime rate indicators.";
                }
            }

            $categories = [
                'Services' => '(TaxiStart + TaxiUnKm + Internet + FitnessClubMonthly + TennisCourtRentOneH + Cinema + OneMminPrepaid) AS Sum_Services',
                'Food' => '(Meal + MealFor2_people + McMeal + Capuccino + CokePepsi + Milk + FreshBread + Rice + Eggs + LocalCheese + ChickenFillets + BeefRound + Apples + Banana + Oranges + Tomato + Potato + Onion + Lettuce + Water) AS Sum_Alimentation',
                'Accomodation' => '(BasicFor85m2 + AppartmentOneBedroomCity + AppartmentOneBedroomOutsideCentre + AppartmentThreeBedroomsCity + AppartmentThreeBedroomsOutsideCentre + PriceSquareMeterBuyApartmentCity + PricePerSquareMeterBuyApartmentOutside) AS Sum_Logement',
                'Others' => '(DomesticBeer + Cigarettes20Pack + OneWayTicket + MonthlyPass + Gasoline + PairOfNike + PairOfMenShoes + SummerDress + AverageMonthlyNetSalary + InterestRate) AS Sum_Autres'
            ];
        
            $data = [];
            foreach ($categories as $key => $value) {
                $query = "SELECT ville.name, $value FROM cout_de_vie INNER JOIN avoir ON cout_de_vie.id_cout = avoir.id_cout INNER JOIN ville ON ville.id_ville = avoir.id_ville WHERE avoir.id_ville IN (?, ?) GROUP BY ville.name";
                $stmt = $pdo->prepare($query);
                $stmt->execute([$ville1_id, $ville2_id]);
                $data[$key] = $stmt->fetchAll(PDO::FETCH_ASSOC);
            }
    ?>

    <div class="section">
        <p id="comparisonComment"><?=$comparisonComment;?></p>
    </div>
    <div>
        <h2>For more details, here you can view the total living costs in different categories</h2>
    </div>
    <div class="body_graph_compare">
        <!-- Graphs for categories -->

        <?php foreach ($data as $category => $values): ?>
            <div class="graph-container">
                <h2><?= $category ?></h2>
                <canvas id="graph<?= htmlspecialchars($category) ?>"></canvas>
            </div>
        <?php endforeach; ?>
    </div>

    
    <?php 
        // Query to get detailed cost of living data for the two cities
        $queryCoutDeVie1 = "SELECT ville.name, ville.id_ville, Meal, McMeal, Capuccino, CokePepsi, Milk, FreshBread, Rice, Eggs, LocalCheese, BeefRound, Apples, Banana, Oranges, Tomato, Potato, Onion, Water, DomesticBeer, OneWayTicket, MonthlyPass, TaxiUnKm, Gasoline, BasicFor85m2, Internet, Cinema, OneJeansLevis, SummerDress, PairOfNike, AppartmentOneBedroomCity, AverageMonthlyNetSalary FROM cout_de_vie INNER JOIN avoir ON cout_de_vie.id_cout = avoir.id_cout INNER JOIN ville ON ville.id_ville = avoir.id_ville WHERE avoir.id_ville IN (?, ?) GROUP BY ville.name";
        $stmt = $pdo->prepare($queryCoutDeVie1);
        $stmt->execute([$ville1_id, $ville2_id]);
        $coutDeVieData1 = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Calculate differences in costs
        $costDifferences = [];
        if (count($coutDeVieData1) == 2) {
            foreach ($coutDeVieData1[0] as $key => $value) {
                if ($key != 'name' && $key != 'id_ville' && isset($coutDeVieData1[1][$key])) {
                    $diff = ($coutDeVieData1[1][$key] != 0) ? (($coutDeVieData1[1][$key]- $value) / $value) * 100 : 0;
                    $costDifferences[$key] = round($diff, 2);
                }
            }
        }


    ?>
    <?php if (!empty($coutDeVieData1)) : ?>
        <br><h2> Here you can view in details some living costs in different categories</h2>
        <!-- Display the comparison table -->
        <div class="body_graph_compare" style ="background-color:#fdfdfd;">
            <div class="comparison-table">
                <table>
                    <thead>
                        <tr>
                            <th>Cost Item</th>
                            <th><?= htmlspecialchars($coutDeVieData1[0]['name']); ?></th>
                            <th><?= htmlspecialchars($coutDeVieData1[1]['name']); ?></th>
                            <th>Difference (%)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($costDifferences as $key => $diff) : ?>
                            <tr>
                                <td><?= htmlspecialchars($key); ?></td>
                                <td>$<?= htmlspecialchars($coutDeVieData1[0][$key]); ?></td>
                                <td>$<?= htmlspecialchars($coutDeVieData1[1][$key]); ?></td>
                                <td style="color: <?= ($diff > 0) ? 'green' : 'red'; ?>;"><?= $diff; ?>%</td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    <?php endif; ?>
    <footer style = "margin-top: 50px;">
        © 2023 UniDiscover
    </footer>

    <?php }else{?>

    <footer>
        © 2023 UniDiscover
    </footer>

    <?php }?>

    <script>
        // JavaScript for handling graphs
        var totalCostsData = <?= json_encode($coutDeVieData); ?>;
        var categoryData = <?= json_encode($data); ?>;

        if (totalCostsData.length > 0) {
            new Chart(document.getElementById('totalCosts'), {
                type: 'bar',
                data: {
                    labels: totalCostsData.map(x => x.name),
                    datasets: [{
                        label: 'Total Cost',
                        data: totalCostsData.map(x => x.Total_cost),
                        backgroundColor: ['rgba(255, 99, 132, 0.5)', 'rgba(54, 162, 235, 0.5)'],
                        borderColor: ['rgba(255, 99, 132, 0.5)', 'rgba(54, 162, 235, 0.5)']
                    }]
                }
            });
        }

        var ctx = document.getElementById('crimeStats').getContext('2d');
        var crimeChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: <?php echo json_encode($crimeStatsData['labels']); ?>,
                datasets: [{
                    label: 'Crime Indicator',
                    data: <?php echo json_encode($crimeStatsData['data']); ?>,
                    backgroundColor: ['rgba(255, 206, 86, 0.5)', 'rgba(75, 192, 192, 0.5)'],
                    borderColor: ['rgba(255, 206, 86, 0.5)', 'rgba(75, 192, 192, 0.5)'],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        Object.keys(categoryData).forEach(cat => {
            new Chart(document.getElementById('graph' + cat), {
                type: 'bar',
                data: {
                    labels: categoryData[cat].map(x => x.name),
                    datasets: [{
                        label: cat,
                        data: categoryData[cat].map(x => x[Object.keys(x)[1]]),
                        backgroundColor: ['rgba(255, 99, 132, 0.5)', 'rgba(54, 162, 235, 0.5)'],
                        borderColor: ['rgba(255, 99, 132, 0.5)', 'rgba(54, 162, 235, 0.5)']
                    }]
                }
            });
        });

        document.getElementById('category').addEventListener('change', function() {
            var selectedCategory = this.value;
            window.location.href = window.location.pathname + '?category=' + selectedCategory;
        });
    </script>

</body>
</html>