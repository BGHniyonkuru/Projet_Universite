<?php
// Établir une connexion à la base de données
$pdo = new PDO('mysql:host=localhost;dbname=projet_universite', 'root', '');

// Récupérer les données des villes depuis la table 'ville'
$stmt = $pdo->query('SELECT * FROM ville');
$villes = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="http://localhost/Projet/style.css" type="text/css" />
    <title>Comparaison des villes</title>
    <!-- Inclure les bibliothèques JavaScript pour les graphiques -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<!-- bandeau en haut de l'écran -->
<div class="container">
			<a href= "accueil.php"><img id="logo" src="http://localhost/Projet/images/logo.png" alt="logo" ></a>

			<ul>
			  <li><a class= "bandeau" href="comparer.php">Compare</a></li>
			  <li><a class= "bandeau" href="localiser.php">Map to locate</a></li>
			  <li><a class= "bandeau" href="predire.php" >Prédict</a></li>
			  <li><a class= "bandeau" href="contact.php" >Contact</a></li>
			  <li><a class= "bandeau" href="search.php" >Search</a></li>
			</ul>
			<a href= "favori.php"><img id="logo2" src="http://localhost/Projet/images/favori.png" alt="logo"></a>
			<a href= "monCompte.php"><img id="logo3" src="http://localhost/Projet/images/monCompte.png" alt="logo"></a>
</div>

<body>
    <h1>Comparaison des villes</h1>
    
    <!-- Formulaire pour sélectionner les villes à comparer -->
    <form id="comparisonForm" action="comparison.php" method="post">
        <label for="ville1">Ville 1 :</label>

        <select name="ville1" id="ville1" required>
            <option value="">Sélectionnez une ville</option>
            <?php foreach ($villes as $ville) : ?>
                <option value="<?= $ville['name'] ?>"><?= $ville['name'] ?></option>
            <?php endforeach; ?>
        </select>
        <label for="ville2">Ville 2 :</label>
       
        <select name="ville2" id="ville2" required>
            <option value="">Sélectionnez une ville</option>
            <?php foreach ($villes as $ville) : ?>
                <option value="<?= $ville['name'] ?>"><?= $ville['name'] ?></option>
            <?php endforeach; ?>
        </select>
        <button type="submit">Comparer</button>
    </form>
    
    <?php 
        
        var_dump($data_crime);
        /*
        var_dump($cout_de_vie_data_2);
        var_dump($crime_data_1);
        var_dump($crime_data_2);
        */
        #var_dump($data);

    ?>

    <!-- Résultats de la comparaison affichés ici -->
    <div>
        <canvas id="coutDeVieChart"></canvas>
    </div>
    <div>
        <canvas id="crimeChart"></canvas>
    </div>

    <script>
        // Attend que le document soit complètement chargé
        $(document).ready(function() {
            // Ajoute un écouteur d'événement sur la soumission du formulaire
            $('#comparisonForm').submit(function(event) {
                // Empêche le comportement par défaut du formulaire (rechargement de la page)
                event.preventDefault();

                // Effectue une requête POST AJAX vers la page 'comparison.php' en utilisant jQuery
                $.ajax({
                    url: 'comparison.php',
                    method: 'POST',
                    data: $(this).serialize(), // Sérialiser les données du formulaire
                    success: function(bar_graph) {

                        $("#divGraph").html(bar_graph);
                        $("$graph").chart = new Chart ($("#graph"),$("#graph").data("settings"));

                        // Réponse de la requête
                        var data = JSON.parse(response);

                        // Dessiner le graphique du coût de la vie
                        drawCostOfLivingChart(data);

                        // Dessiner le graphique des crimes
                        drawCrimeChart(data);
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                    }
                });
            });
        });

        // Fonction pour dessiner le graphique du coût de la vie
        function drawCostOfLivingChart(data) {
            new Chart($('#coutDeVieChart'), {
                type: 'bar',
                data: {
                    labels: ['Ville 1', 'Ville 2'],
                    datasets: [{
                        label: 'Coût de la vie',
                        data: [data.data_cout_de_vie.cout_de_vie_moyen_ville1, data.data_cout_de_vie.cout_de_vie_moyen_ville2],
                        backgroundColor: ['#36A2EB', '#FF6384'],
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
        }

        // Fonction pour dessiner le graphique des crimes
        function drawCrimeChart(data) {
            new Chart($('#crimeChart'), {
                type: 'bar',
                data: {
                    labels: ['Ville 1', 'Ville 2'],
                    datasets: [{
                        label: 'Taux de criminalité',
                        data: [data.data_crime.crime_moyen_ville1, data.data_crime.crime_moyen_ville2],
                        backgroundColor: ['#FFCE56', '#4BC0C0'],
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
        }
    </script>
</body>
</html>