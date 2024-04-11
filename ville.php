<?php
session_start();
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
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
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
            margin: 20px auto;
            padding: 20px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .graph-container {
            margin-bottom: 20px;
        }

        h1 {
            margin-top: 0;
            font-size: 24px;
        }

        h2 {
            margin-top: 20px;
            font-size: 20px;
        }

         
    </style>

</head>

<div class="container">
    <a href="accueil.php"><img src="images/logo.png" alt="logo"></a>

    <nav>
        <ul>
            <li><a href="comparer.php">Comparer</a></li>
            <li><a href="localiser.php">Carte</a></li>
            <li><a href="predire.php">Prédire</a></li>
            <li><a href="contact.php">Contact</a></li>
            <li><a href="search.php">Rechercher</a></li>
        </ul>
    </nav>

    <a href="favoris.php"><img src="images/favori.png" alt="favori"></a>
    <a href="monCompte.php"><img src="images/monCompte.png" alt="mon compte"></a>
</div>

<body>
    <?php
    // Établir une connexion à la base de données
    $pdo = new PDO('mysql:host=localhost;dbname=projet_universite', 'root', '');

    // Requête pour récupérer les noms des villes
    $queryVilles = "SELECT distinct(name),id_ville  FROM ville";
    $resultVilles = $pdo->query($queryVilles);
    $villes = $resultVilles->fetchAll(PDO::FETCH_ASSOC);

    // Traitement du formulaire
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $ville1_id = $_POST["ville1"];
        $ville2_id = $_POST["ville2"];

        // Requête pour le premier graphique - moyenne des coûts de vie des deux villes
        $queryCoutDeVie = "SELECT ville.name, AVG((Meal + MealFor2_people + McMeal + Capuccino + CokePepsi + Milk + FreshBread + Rice + Eggs + LocalCheese + ChickenFillets + BeefRound + Apples + Banana + Oranges + Tomato + Potato + Onion + Lettuce + Water + DomesticBeer + Cigarettes20Pack + OneWayTicket + MonthlyPass + TaxiStart + TaxiUnKm + Gasoline + BasicFor85m2 + OneMminPrepaid + Internet + FitnessClubMonthly + TennisCourtRentOneH + Cinema + OneJeansLevis + SummerDress + PairOfNike + PairOfMenShoes + AppartmentOneBedroomCity + AppartmentOneBedroomOutsideCentre + AppartmentThreeBedroomsCity + AppartmentThreeBedroomsOutsideCentre + PriceSquareMeterBuyApartmentCity + PricePerSquareMeterBuyApartmentOutside + AverageMonthlyNetSalary + InterestRate) / 41) AS indicator
                            FROM cout_de_vie
                            INNER JOIN avoir ON cout_de_vie.id_cout = avoir.id_cout
                            INNER JOIN ville ON ville.id_ville = avoir.id_ville
                            WHERE avoir.id_ville IN (?, ?)
                            GROUP BY ville.name";
        $stmt = $pdo->prepare($queryCoutDeVie);
        $stmt->execute([$ville1_id, $ville2_id]);
        $coutDeVieData = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Requête pour le deuxième graphique - comparaison des attributs de la table "crime"
        $queryCrimeAttributes = "SELECT ville.name, crime.* FROM ville LEFT JOIN `crime` ON ville.id_ville = crime.id_ville WHERE crime.id_ville IN (?, ?)";
        $stmt = $pdo->prepare($queryCrimeAttributes);
        $stmt->execute([$ville1_id, $ville2_id]);
        $crimeAttributes = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Vérifiez si des données ont été renvoyées
        if (!empty($crimeAttributes)) {
            // Préparation des données pour le deuxième graphique
            $labels2 = array_keys($crimeAttributes[0]); // Utilisez les noms de colonnes comme étiquettes
            $values2Ville1 = array_values($crimeAttributes[0]); // Données pour la ville 1
            $values2Ville2 = array_values($crimeAttributes[1]); // Données pour la ville 2
        } else {
            // Aucune donnée n'a été renvoyée, initialisez les variables avec des valeurs vides
            $labels2 = [];
            $values2Ville1 = [];
            $values2Ville2 = [];
        }
    }
?>



<div class="body_graph_compare">
    <h1>Comparaison de villes</h1>
    <form method="post">
        <div class="mb-3">
            <label for="ville1" class="form-label">Ville 1 :</label>
            <select class="form-select" name="ville1" id="ville1" required>
                <option value="">Sélectionnez une ville</option>
                <?php foreach ($villes as $ville) : ?>
                    <option value="<?= $ville['id_ville'] ?>"><?= $ville['name'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="ville2" class="form-label">Ville 2 :</label>
            <select class="form-select" name="ville2" id="ville2" required>
                <option value="">Sélectionnez une ville</option>
                <?php foreach ($villes as $ville) : ?>
                    <option value="<?= $ville['id_ville'] ?>"><?= $ville['name'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Comparer</button>
    </form>

    <!-- Graphique 1 - Moyenne des coûts de vie -->
    <div class="graph-container">
        <h2>Coûts de vie total</h2>
        <canvas id="graphique1"></canvas>
    </div>

    <!-- Graphique 2 - Comparaison des attributs de la table "crime" -->
    <div class="graph-container">
        <h2>Comparaison des attributs de la table "crime"</h2>
        <canvas id="graphique2"></canvas>
    </div>

    <!-- Graphique 3 - Comparaison des coûts de vie des deux villes -->
    <div class="graph-container">
        <h2>Comparaison des coûts de vie des deux villes</h2>
        <canvas id="graphique3"></canvas>
    </div>
</div>

<footer>
    © 2023 UniDiscover
</footer>


<script>
    // Code JavaScript pour les graphiques

    // Graphique 1 - Moyenne des coûts de vie
    var ctx1 = document.getElementById('graphique1').getContext('2d');
    var coutDeVieData = <?php echo json_encode($coutDeVieData); ?>;
    if (coutDeVieData.length > 0) {
        var labels1 = coutDeVieData.map(function(data) { return data.name; });
        var values1 = coutDeVieData.map(function(data) { return data.indicator; });

        var graphique1 = new Chart(ctx1, {
            type: 'bar',
            data: {
                labels: labels1,
                datasets: [{
                    label: 'Moyenne des coûts de vie',
                    data: values1,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)'
                    ],
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
    } else {
        document.getElementById('graphique1').innerHTML = "Données non disponibles pour la première ville sélectionnée";
    }

    // Graphique 2 - Comparaison des attributs de la table "crime"
    var ctx2 = document.getElementById('graphique2').getContext('2d');
    var labels2 = <?php echo json_encode($labels2); ?>;
    var values2Ville1 = <?php echo json_encode($values2Ville1); ?>;
    var values2Ville2 = <?php echo json_encode($values2Ville2); ?>;
    if (labels2.length > 0 && values2Ville1.length > 0 && values2Ville2.length > 0) {
        var graphique2 = new Chart(ctx2, {
            type: 'bar',
            data: {
                labels: labels2,
                datasets: [{
                    label: 'Ville 1',
                    data: values2Ville1,
                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                    borderColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 1
                }, {
                    label: 'Ville 2',
                    data: values2Ville2,
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgba(54, 162, 235, 1)',
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
    } else {
        document.getElementById('graphique2').innerHTML = "Données non disponibles pour la deuxième ville sélectionnée";
    }

    // Graphique 3 - Comparaison des coûts de vie des deux villes
    var ctx3 = document.getElementById('graphique3').getContext('2d');
    if (coutDeVieData.length > 0) {
        var graphique3 = new Chart(ctx3, {
            type: 'pie',
            data: {
                labels: labels1,
                datasets: [{
                    label: 'Comparaison des coûts de vie',
                    data: values1,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)'
                    ],
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
    } else {
        document.getElementById('graphique3').innerHTML = "Données non disponibles pour la première ville sélectionnée";
    }
</script>
    
</body>
</html>