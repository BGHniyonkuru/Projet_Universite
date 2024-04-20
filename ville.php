<?php
session_start();

    // Établir une connexion à la base de données
    $pdo = new PDO('mysql:host=localhost;dbname=projet_universite', 'root', '');

    // Requête pour récupérer les noms des villes
    $queryVilles = "SELECT distinct(ville.name),ville.id_ville,name_etat FROM avoir, ville, crime where avoir.id_ville=ville.id_ville and ville.id_ville=crime.id_ville";
    $resultVilles = $pdo->query($queryVilles);
    $villes = $resultVilles->fetchAll(PDO::FETCH_ASSOC);

    // Traitement du formulaire
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $ville1_id = $_POST["ville1"];
        $ville2_id = $_POST["ville2"];

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
            display: flex;
            flex-wrap: wrap;  /* Allows items to wrap as needed */
            justify-content: center; /* Centers items horizontally */
            align-items: center;  /* Align items vertically */
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
        .container {
            background-color: #3C3B6E;
            color: white;
            padding-top: 10px;
            padding-bottom: 10px;
            display: flex;
            justify-content: center;
            align-items: center;
            width: 100%;
            margin-left: 0px;
            margin-right: 0px;
            max-width: none;
        }
        .container ul {
            list-style-type: none;
            margin: 0;
            padding: 0;
        }
        .container ul li {
            display: inline;
            margin-left: 20px;
        }
        .container ul li a {
            color: white;
            text-decoration: none;
        }
        .container ul li a:hover {
            color: #ccc;
        }

        .search-box {
            flex-grow: 1; /* Search elements take all available space */
            margin: 5px; /* Margin around search bars */
        }
        .search-container {
            #border: 2px solid red;
            display: flex;              /* Ceci active Flexbox pour le conteneur */
            justify-content: space-around; /* Ceci répartit l'espace uniformément autour des éléments */
            flex-direction: row;
            width: 100%;
            flex-wrap: wrap;  /* Allows items to wrap as needed */
            justify-content: center; /* Centers items horizontally */
            align-items: center;  /* Align items vertically */

        }
        .form-label, {
            flex: 1;                    /* Ceci permet aux champs de recherche de prendre tout l'espace disponible */
            margin: 5px;                /* Ceci ajoute un peu d'espace autour des barres pour éviter qu'elles ne se touchent */
        }
        .btn{
            #border: solid 2px black;
            width: 200px;
            border-radius: 50%; /* Pour une forme ovale */
            background-color: #3C3B6E; /* Couleur de fond bleu royal */
            color: white; /* Couleur du texte */
            padding: 10px 20px; /* Espacement interne */
            border: none; /* Pas de bordure */
            cursor: pointer; /* Curseur pointeur au survol */
            font-size: 16px; 
        }
        .barre{
            #border: solid 2px red;
            margin: 10px;
        }
        #category{
            #border: solid 2px green;
            width: 200px;
        }
    </style>
</head>

<body>

    <!-- Bandeau en haut de l'écran -->
    <div class="container">
        <a href= "accueil.php"><img id="logo" src="http://localhost/Projet/images/logo.png" alt="logo"></a>

        <ul>
        <li><a class= "bandeau" href="comparer.php">Compare</a></li>
        <li><a class= "bandeau" href="localiser.php">Map</a></li>
        <li><a class= "bandeau" href="predire.php" >Predict</a></li>
        <li><a class= "bandeau" href="contact.php" >Contact</a></li>
        <li><a class= "bandeau" href="search.php" >Search</a></li>
        </ul>
        <a href= "favoris.php"><img id="logo2" src="http://localhost/Projet/images/favori.png" alt="logo"></a>
        <a href= "monCompte.php"><img id="logo3" src="http://localhost/Projet/images/monCompte.png" alt="logo"></a>
    </div>

    <h1>City's comparison</h1>
    <div class="search-container">
        <form method="post" class="search-container">
            <div class = 'barre'>
                <label for="ville1" class="form-label">First city :</label>
                <select class="form-select" name="ville1" id="ville1" required>
                    <option value="">Choose a city</option>
                    <?php foreach ($villes as $ville) : ?>
                        <option value="<?= $ville['id_ville'] ?>"><?= $ville['name']." - ".$ville['name_etat']?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class = 'barre'>
                <label for="ville2" class="form-label">Second city :</label>
                <select class="form-select" name="ville2" id="ville2" required>
                    <option value="">Choose a city</option>
                    <?php foreach ($villes as $ville) : ?>
                        <option value="<?= $ville['id_ville'] ?>"><?= $ville['name']." - ".$ville['name_etat'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
                
            
            <button type="submit" class="btn btn-primary">Compare</button>
        </form>

    </div>

    <div class="body_graph_compare">
        <div class="graph-container">
            <h2>Total cost of living</h2>
            <canvas id="totalCosts"></canvas>
        </div>
        <div class="graph-container">
            <h2>Crime infos</h2>
            <canvas id="crimeStats"></canvas>
        </div>
    </div> 
    
    <div class="search-container">
        <label for="category" class="form-label">Choose a category:</label>
        <select class="form-select" name="category" id="category">
            <?php foreach ($categories as $key => $value) : ?>
                <option value="<?= $key ?>" <?= ($key === 'Services') ? 'selected' : '' ?>><?= $key ?></option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="body_graph_compare">
        <!-- Graphs for categories -->


<!-- le probleme est de là -->

        <?php        
         // Récupérer la catégorie sélectionnée à partir des paramètres GET ou utiliser une valeur par défaut
        $category = $_GET['category'] ?? 'Services';

        // Afficher le graphique correspondant à la catégorie sélectionnée
        if (isset($data[$category])) {
            echo '<div class="graph-container">';
            echo '<h2>' . htmlspecialchars($category) . '</h2>';
            echo '<canvas id="graph' . htmlspecialchars($category) . '"></canvas>';
            echo '</div>';
        } ?>
        
        <?php foreach ($data as $category => $values): ?>
            <div class="graph-container">
                <h2><?= $category ?></h2>
                <canvas id="graph<?= htmlspecialchars($category) ?>"></canvas>
            </div>
        <?php endforeach; ?>

<!-- jusqu'ici je pense ou la derniere partie du script -->

    </div>

    <footer>
        © 2023 UniDiscover
    </footer>



<script>
        // Définition des données pour les graphiques
        var totalCostsData = <?= json_encode($coutDeVieData); ?>;
        var crimeStatsData = <?= json_encode($crimeAttributes); ?>;
        var categoryData = <?= json_encode($data); ?>;

        // Création des graphiques
        if (totalCostsData.length > 0) {
            new Chart(document.getElementById('totalCosts'), {
                type: 'bar',
                data: {
                    labels: totalCostsData.map(x => x.name),
                    datasets: [{
                        label: 'Total Cost',
                        data: totalCostsData.map(x => x.Total_cost),
                        backgroundColor: 'rgba(255, 99, 132, 0.2)',
                        borderColor: 'rgba(255, 99, 132, 1)'
                    }]
                }
            });
        }

        if (crimeStatsData.length > 0) {
            new Chart(document.getElementById('crimeStats'), {
                type: 'bar',
                data: {
                    labels: Object.keys(crimeStatsData[0]),
                    datasets: [{
                        label: 'Crime Stats',
                        data: Object.values(crimeStatsData[0]),
                        backgroundColor: 'rgba(54, 162, 235, 0.2)',
                        borderColor: 'rgba(54, 162, 235, 1)'
                    }]
                }
            });
        }

        Object.keys(categoryData).forEach(cat => {
            new Chart(document.getElementById('graph' + cat), {
                type: 'bar',
                data: {
                    labels: categoryData[cat].map(x => x.name),
                    datasets: [{
                        label: cat,
                        data: categoryData[cat].map(x => x[Object.keys(x)[1]]),
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        borderColor: 'rgba(75, 192, 192, 1)'
                    }]
                }
            });
        });

        // JavaScript pour détecter les changements dans le menu déroulant de la catégorie
        document.getElementById('category').addEventListener('change', function() {
            // Récupérer la valeur sélectionnée dans le menu déroulant
            var selectedCategory = this.value;
            // Rediriger vers la même page avec la catégorie sélectionnée comme paramètre GET
            window.location.href = window.location.pathname + '?category=' + selectedCategory;
        });

</script>

</body>
</html>