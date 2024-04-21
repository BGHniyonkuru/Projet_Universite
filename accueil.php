<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.0/chart.min.js"></script>

    <title>Accueil</title>
    <style>
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

        #searchResults {
            margin-left: 5px;
        }
        
	    #body_accueil {   
            min-height: 100vh; /* Pour s'assurer que le contenu remplit au moins la hauteur de l'écran */
			margin: 0;
			padding: 0;
            flex-grow: 1; /* Pour que le contenu s'étende et remplisse l'espace disponible */
			position: relative; /* Permet d'utiliser une position absolue pour la superposition */
		}

        #podium {
			margin-top: 0px;
            display: flex;
            justify-content: space-between;
            align-items: center; /* Centre les cellules verticalement */
            background-image: url('images/podium.jpeg');
            background-size: cover;
            background-position: center;
            padding: 5px;
            margin: 0 auto;                    
            width: 600px;
            height: 250px; /* Ajustez la hauteur selon vos besoins */
            
            color: black;
        }

        .podium-cell {
            text-align: center;
            width: 30%;
        }

        #podium-cell-2 {
			margin-top: 1px;
			margin-bottom: 100px;
			align-self: center; /* Place la première cellule au centre */
		}

		#podium-cell-4 {
			margin-bottom: 40px;
            margin-left: 20px;
    		margin-right:  auto; /* Place la deuxième cellule à gauche */
		}

		#podium-cell-5 {
            
			margin-top: 0px;
            margin-right: 20px;
			margin-left: auto; /* Place la troisième cellule à droite */
		}
		
		.quick-links {
            margin-top: 20px;
            text-align: center;
        }
        .quick-links p {
            font-weight: bold;
            margin-bottom: 5px;
        }
        .quick-links a {
            display: inline-block;
            margin: 5px;
            padding: 10px 20px;
            background-color: #3C3B6E;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            transition: 0.3s;
        }
        .quick-links a:hover {
            background-color: #555;
        }

		.site-description {
            margin-top: 50px;
            margin-bottom: 30px;
            font-size: 18px;
            line-height: 1.6;
            
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: justify;
            
        }
        .site-description p:first-of-type {
            font-weight: bold;
        }
        .site-description p {
            margin-bottom: 10px;
        }
        .section{
            padding:20px;
            background-color: #F9F3EA;            
            padding: 20px;
            margin: 20px auto;
            border-radius: 10px;
            box-shadow: 0px 0px 10px 0px rgba(0,0,0,0.8);
            max-width: 500px;
            text-align: center;
            min-width: 60%;
        }

		.section-title {
            
			padding:7px;
			background-color: #D7DCE3;
            text-align: center;
            margin-bottom: 10px;
            font-size: 24px;
            color: #333;
			width: 600px;
			margin-left: auto;
            margin-right: auto;
            
        }

        body {
            background-image: url("images/kellym.jpg");
			background-position: center;
			background-size: cover;
            min-height: 100vh;
            margin: 0px;
            padding: 0px;
            display: flex;
            flex-direction: column;
            
            min-height: 100vh;
        }
        
        .centered-list {
            margin-top: 50px;
            background-color: white;
            width: 615px;
            margin-left: auto;
            margin-right: auto;
            
            text-justify: left;
            text-align: center; /* Centre le contenu de la liste */
            list-style-type: none; /* Supprime les puces de la liste */
            padding-left: 0; /* Supprime les marges intérieures de la liste */
        }

        .centered-list li {
            
            display: inline-block; /* Affiche les éléments de la liste en ligne */
            margin: 8px; /* Ajoute une marge autour de chaque élément de la liste */
        }

        .recommandations{
            margin-bottom: 2px;
        }

        #chart-container {
            width: 600px;
            height: 400px;
            margin: 0 auto;
            margin-top: 20px;
            padding-bottom: 2px;
        }
 
        
        canvas{
            margin-bottom: 2px ;
            
        }
        .container {
            height:90px;
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
        <li><a class= "bandeau" href="predire.php" >Predict</a></li>
        <li><a class= "bandeau" href="contact.php" >Contact</a></li>
        <li><a class= "bandeau" href="search.php" >Search</a></li>
    </ul>
    <a href= "favoris.php"><img id="logo2" src="images/favori.png" alt="logo"></a>
    <a href= "monCompte.php"><img id="logo3" src="images/monCompte.png" alt="logo"></a>
</div>
<div id='body_accueil'>
    <div class = "section">
        <!-- site description section -->
            <div class="site-description">
                <?php if(isset($_SESSION['client'])){?>
                    <p>Welcome to <i><b>UniDiscover </b></i><?php echo $_SESSION['client']['prenom'];?>🤗</p>
                    
                <?php }else{?>
                    <p>Welcome to <i><b>UniDiscover</b>!</i></p>
                    
                <?php }?>
                <p>Discover colleges worldwide and find the perfect match for you.</p>
                <p><b>Why is it innovative?</b></p>
                <p>This website stands out from others by allowing users to compare universities globally based on their chosen criteria. Users can also track the ranking changes of universities over time through descriptive statistics and graphical representations.</p>
            
            </div>
    </div>
    
    <div class = "section">
            <!--titre après le texte de description -->
            <h1 class="section-title">Top 3 Best Colleges in 2023</h1>

        <div id="podium">
            <?php
            require("bd.php");
            $bdd = getBD();
            $requete="SELECT name, rank_order, annee 
                        FROM universite, classement, etre 
                        WHERE universite.id_universite = etre.id_universite 
                        AND etre.id_classement = classement.id_classement 
                        AND classement.id_classement IN 
                        ( SELECT id_classement FROM classement 
                        WHERE annee = 2023 AND rank_order IN (2, 4, 5)) 
                        ORDER BY CASE rank_order 
                        WHEN 4 THEN 1 
                        WHEN 2 THEN 2 
                        WHEN 5 THEN 3 
                        END";
            $sql = $bdd->prepare($requete);
            $sql->execute();

            $universities = array();
            
            
            while ($row = $sql->fetch()) {
                $universities[$row['rank_order']] = $row;
            }

            // Parcours des universités
            foreach ($universities as $rank => $university) {

                // Affichage de la cellule du podium
                echo '<div id="podium-cell-' . $rank . '" class="podium-cell">';
                echo '<h2>' . $university['name'] . '</h2>';
                #echo '<p>Mondial Rank: ' . $rank . '</p>';
                #echo '<p>Year: ' . $university['annee'] . '</p>';
                echo '</div>';
                /*echo "<img src= 'images/etoile.jpg'>";*/
                
            }
            ?>
        </div>
    </div>
    <?php 
        // Récupérer les critères du questionnaire depuis la session
        if (isset($_SESSION['client'])) {

            $client_id =$_SESSION['client']['id'];
            $requete = "SELECT diplome, type_univ, budget, etat, domaine
                    FROM recommandations 
                    WHERE id_client= :client_id";
            $sql = $bdd->prepare($requete);
            $sql->bindParam(":client_id", $client_id);
            $sql->execute();

            $recommandations = $sql->fetch();
            if ($recommandations){

                $questions = $recommandations;
                $diplome = $questions['diplome'];
                $type_univ = $questions['type_univ'];
                $budget = $questions['budget'];
                $etat = $questions['etat'];
                $domaine_etude = $questions['domaine'];

                // Exécution de la requête SQL pour récupérer les universités correspondantes aux critères
                $bdd = getBD();
                $requete = "SELECT universite.name 
                            FROM universite, ville 
                            WHERE ville.id_ville = universite.id_ville 
                            AND universite.price <= $budget 
                            AND ville.name_etat LIKE '%$etat%'  
                            AND universite.domaine_etude LIKE '%$domaine_etude%'  
                            AND universite.description LIKE '%$type_univ%'";
                $sql = $bdd->prepare($requete);
                $sql->execute();

                $universites_recommandees = array();
                
                    while ($row = $sql->fetch()) {
                        $universites_recommandees[] = $row['name'];
                    }
        
    ?>

    <!-- Section pour afficher les universités recommandées -->
    <div class="section">
        <h1 class="section-title">College recommendations</h1>
        <div class="recommandations" style = "margin-top: 10px;">
            <ul class="centered-list">
            <?php 
                // Vérifier si des universités ont été recommandées
                if (isset($_SESSION['client'])) {
                    // Parcourir les universités recommandées
                    foreach ($universites_recommandees as $universite) {
                        echo '<li>' . $universite . '</li>';
                        echo '<br>';
                    }
                }else{ 
                echo 'No university found based exactly on your criteria.😓';
                }
            }
        }
            ?>
            </ul>
        </div>
    </div>    

    <!-- Section pour afficher les villes avec le plus d'universités sous forme de nuage de points -->
    <div class="section">
        <h1 class="section-title">Top 10 Cities with the most top-ranked universities</h1>
        <!-- Conteneur pour le graphique -->
        <div id="chart-container">
            <canvas id="myChart"></canvas>
        </div>
    </div>
    
   
    

    <div class = "section">
        <!-- quick links section -->
        <div class="quick-links">
            <p>Explore our helpful resources:</p>
            <p>College Application Preparation:</p>
            <a href="https://www.topuniversities.com/student-info/admissions-advice">Click here for valuable tips on preparing your college applications.</a>
            <p>Exam Preparation Tips:</p>
            <a href="https://www.universitiesuk.ac.uk/policy-and-analysis/reports/Documents/2019/adjustment-and-clearing-guide-2019.pdf">Access to a page for expert advice on acing your exams.</a>
        </div>
    </div>
</div>

<footer>
    Copyright © 2023 UniDiscover
</footer>
 <!-- Script JavaScript pour générer le nuage de points avec Chart.js -->
    <script>
        // Récupération des données PHP depuis la base de données
        <?php
        
        $requete = "SELECT ville.name AS city, COUNT(universite.id_universite) AS num_universities 
                    FROM ville 
                    INNER JOIN universite ON ville.id_ville = universite.id_ville 
                    GROUP BY ville.name 
                    ORDER BY num_universities DESC 
                    LIMIT 10";
        $sql = $bdd->prepare($requete);
        $sql->execute();

        $cities = [];
        $num_universities = [];

        while ($row = $sql->fetch()) {
            $cities[] = $row['city'];
            $num_universities[] = $row['num_universities'];
        }
        ?>

        // Création du nuage de points avec Chart.js
        var ctx = document.getElementById('myChart').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: <?php echo json_encode($cities); ?>,
                datasets: [{
                    label: 'Number of top-ranked colleges',
                    data: [
                        <?php 
                        // Boucle pour générer les données du nuage de points
                        for ($i = 0; $i < count($cities); $i++) {
                            echo "{x: '$cities[$i]', y: $num_universities[$i]},";
                        }
                        ?>
                    ],
                    backgroundColor:'#3C3B6E', // Couleur de fond
                    borderColor: 'midnightblue', // Couleur de la bordure
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    x: {
                        title: {
                            display: true,
                            text: 'Cities'
                        }
                    },
                    y: {
                        title: {
                            display: true,
                            text: 'Number of top-ranked colleges'
                        },
                        beginAtZero: true
                    }
                }
            }
        });
    </script>

</body>
</html>

