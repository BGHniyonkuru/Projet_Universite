<?php
session_start();
$pdo = new PDO('mysql:host=localhost;dbname=projet_universite', 'root', '');

// Requête pour récupérer les noms des villes
$queryVilles = "SELECT DISTINCT(ville.name), ville.id_ville, name_etat FROM avoir, ville, crime WHERE avoir.id_ville=ville.id_ville AND ville.id_ville=crime.id_ville";
$resultVilles = $pdo->query($queryVilles);
$villes = $resultVilles->fetchAll(PDO::FETCH_ASSOC);

    // Traitement du formulaire
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
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

        // Requête pour le deuxième graphique - comparaison des attributs de la table "crime"
        $queryCrimeAttributes = "SELECT crime.victims_killed,crime.victims_injured,crime.suspects_killed,crime.suspects_injured,crime.suspects_arrested FROM `crime`,ville where crime.id_ville=ville.id_ville and crime.id_ville IN (?, ?)";
        $stmt = $pdo->prepare($queryCrimeAttributes);
        $stmt->execute([$ville1_id, $ville2_id]);
        $crimeAttributes = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Vérifiez si des données ont été renvoyées
        if (!empty($crimeAttributes)) {
            // Préparation des données pour le deuxième graphique
            if (count($crimeAttributes) >= 2) {
                // Préparation des données pour le deuxième graphique
                $labels2 = array_keys($crimeAttributes[0]); // Utilisez les noms de colonnes comme étiquettes
                $values2Ville1 = array_values($crimeAttributes[0]); // Données pour la ville 1
                $values2Ville2 = array_values($crimeAttributes[1]); // Données pour la ville 2
            } else {
                // Si le tableau contient moins de deux éléments, initialisez les variables avec des valeurs vides
                $labels2 = [array_keys($crimeAttributes[0])];
                $values2Ville1 = [array_values($crimeAttributes[0])];
                $values2Ville2 = [array_values($crimeAttributes[0])];
            }
        } else {
            // Aucune donnée n'a été renvoyée, initialisez les variables avec des valeurs vides
            $labels2 = [];
            $values2Ville1 = [];
            $values2Ville2 = [];
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

    }else{

        $categories = [
            'Services' => '(TaxiStart + TaxiUnKm + Internet + FitnessClubMonthly + TennisCourtRentOneH + Cinema + OneMminPrepaid) AS Sum_Services',
            'Food' => '(Meal + MealFor2_people + McMeal + Capuccino + CokePepsi + Milk + FreshBread + Rice + Eggs + LocalCheese + ChickenFillets + BeefRound + Apples + Banana + Oranges + Tomato + Potato + Onion + Lettuce + Water) AS Sum_Alimentation',
            'Accomodation' => '(BasicFor85m2 + AppartmentOneBedroomCity + AppartmentOneBedroomOutsideCentre + AppartmentThreeBedroomsCity + AppartmentThreeBedroomsOutsideCentre + PriceSquareMeterBuyApartmentCity + PricePerSquareMeterBuyApartmentOutside) AS Sum_Logement',
            'Others' => '(DomesticBeer + Cigarettes20Pack + OneWayTicket + MonthlyPass + Gasoline + PairOfNike + PairOfMenShoes + SummerDress + AverageMonthlyNetSalary + InterestRate) AS Sum_Autres'
        ];
         //Si aucun formulaire n'a été soumis, récupérer la catégorie par défaut depuis les paramètres GET
        $category = $_GET['category'] ?? 'Services';
        // Exécuter la requête avec la catégorie par défaut
        $query = "SELECT ville.name, {$categories[$category]} FROM cout_de_vie INNER JOIN avoir ON cout_de_vie.id_cout = avoir.id_cout INNER JOIN ville ON ville.id_ville = avoir.id_ville WHERE avoir.id_ville IN (?, ?) GROUP BY ville.name";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$ville1_id, $ville2_id]);
        $categoryData = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comparaison des villes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            padding: 20px;
        }
        .container, .search-container, .graph-container {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-top: 20px;
        }
        .container {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .container ul {
            list-style: none;
            padding: 0;
        }
        .container ul li {
            display: inline;
            margin-right: 10px;
        }
        .container ul li a {
            color: white;
            text-decoration: none;
            background-color: #007bff;
            padding: 10px 15px;
            border-radius: 5px;
        }
        .container ul li a:hover {
            background-color: #0056b3;
        }
        .search-box {
            width: 100%;
        }
        .search-box input[type="text"], .search-box button {
            padding: 10px;
            margin: 5px 0;
        }
        .search-box button {
            width: 100%;
        }
    </style>
</head>
<body>
    <div class="container">
        <img src="images/logo.png" alt="Logo" style="height: 80px;">
        <nav>
            <ul>
                <li><a href="comparer.php">Comparer</a></li>
                <li><a href="localiser.php">Localiser</a></li>
                <li><a href="predire.php">Prédire</a></li>
                <li><a href="contact.php">Contact</a></li>
                <li><a href="search.php">Recherche</a></li>
            </ul>
        </nav>
    </div>

    <div class="search-container">
        <form method="post">
            <div class="search-box">
                <input type="text" name="ville1" id="ville1" class="form-control" placeholder="Première ville">
                <button type="submit" class="btn btn-primary">Comparer</button>
            </div>
        </form>
    </div>

    <div class="graph-container">
        <h2>Coût total de la vie</h2>
        <canvas id="totalCosts"></canvas>
        <h2>Informations sur la criminalité</h2>
        <canvas id="crimeStats"></canvas>
    </div>

    <!-- le probleme est de là -->

        
        <?php foreach ($data as $category => $values): ?>
            <div class="graph-container">
                <h2><?= $category ?></h2>
                <canvas id="graph<?= htmlspecialchars($category) ?>"></canvas>
            </div>
        <?php endforeach; ?>

<!-- jusqu'ici je pense ou la derniere partie du script -->


    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        var totalCostsChart = new Chart(document.getElementById('totalCosts'), {
            type: 'bar',
            data: {
                labels: ['Ville A', 'Ville B'],
                datasets: [{
                    label: 'Coût Total',
                    data: [2000, 1500],
                    backgroundColor: ['rgba(255, 99, 132, 0.5)', 'rgba(54, 162, 235, 0.5)']
                }]
            }
        });

        var crimeStatsChart = new Chart(document.getElementById('crimeStats'), {
            type: 'bar',
            data: {
                labels: ['Ville A', 'Ville B'],
                datasets: [{
                    label: 'Statistiques Criminelles',
                    data: [50, 30],
                    backgroundColor: ['rgba(255, 206, 86, 0.5)', 'rgba(75, 192, 192, 0.5)']
                }]
            }
        });
    </script>


</body>
</html>
