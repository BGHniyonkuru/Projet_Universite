<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css" type="text/css" />

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

        html, body {
			
            margin: 0;
            padding: 0;
            width: 100%;
            height: 100%;
        }
		body {
			background-image: url("images/campus.jpg");
			background-position: center center;
			#background-size: cover;
			min-height: 100vh;
			margin: 0;
			padding: 0;
			position: relative; /* Permet d'utiliser une position absolue pour la superposition */
		}

        #podium {
			margin-top: 0px;
            display: flex;
            justify-content: space-between;
            align-items: center; /* Centre les cellules verticalement */
            background-image: url('images/background.png');
            background-size: cover;
            padding: 20px;
            
            margin-left:160px;
            width: 790px;
            height: 500px; /* Ajustez la hauteur selon vos besoins */
        }

        .podium-cell {
			
            text-align: center;
            width: 30%;
        }

        #podium-cell-2 {
			margin-top: 0px;
			margin-bottom: 60px;
			align-self: center; /* Place la première cellule au centre */
		}

		#podium-cell-4 {
			margin-bottom: 20px;
    		margin-right: auto; /* Place la deuxième cellule à gauche */
		}

		#podium-cell-5 {
			margin-top: 70px;
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
            transition: background-color 0.3s;
        }
        .quick-links a:hover {
            background-color: #555;
        }

		.site-description {
            text-align: center;
            margin-top: 50px;
            margin-bottom: 30px;
            font-size: 18px;
            line-height: 1.6;
            color: #333;
        }
        .site-description p:first-of-type {
            font-weight: bold;
        }
        .site-description p {
            margin-bottom: 10px;
        }
		.section-title {
			padding:7px;
			background-color: grey;
            text-align: center;
            margin-bottom: 0px;
            font-size: 24px;
            color: #333;
			width: 800px;
			margin-left: 160px;
            
        }
		
    </style>
</head>
<body id="body_accueil">

<div class="container">

    <a href= "accueil.php"><img id="logo" src="images/logo.png" alt="logo" ></a>

    <ul>
        <li><a class= "bandeau" href="comparer.php">Compare</a></li>
        <li><a class= "bandeau" href="localiser.php">Map</a></li>
        <li><a class= "bandeau" href="predire.php" >Prédict</a></li>
        <li><a class= "bandeau" href="contact.php" >Contact</a></li>
        <li><a class= "bandeau" href="search_university.html" >Search</a></li>
    </ul>
    <a href= "favoris.php"><img id="logo2" src="images/favori.png" alt="logo"></a>
    <a href= "monCompte.php"><img id="logo3" src="images/monCompte.png" alt="logo"></a>
</div>


<!-- site description section -->
    <div class="site-description">
        <p>Welcome to <i><b>UniDiscover</b>!</i></p>
        <p>Discover universities worldwide and find the perfect match for you.</p>
        <p>Why is it innovative?</p>
        <p>This website stands out from others by allowing users to compare universities globally based on their chosen criteria. Users can also track the ranking changes of universities over time through descriptive statistics and graphical representations.</p>
    </div>
	<!--titre après le texte de description -->
	<h1 class="section-title">Top 3 Best Universities in 2023</h1>

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

<!-- quick links section -->
<div class="quick-links">
        <p>Explore our helpful resources:</p>
        <p>College Application Preparation:</p>
        <a href="https://www.topuniversities.com/student-info/admissions-advice">Click here for valuable tips on preparing your college applications.</a>
        <p>Exam Preparation Tips:</p>
        <a href="https://www.universitiesuk.ac.uk/policy-and-analysis/reports/Documents/2019/adjustment-and-clearing-guide-2019.pdf">Access to a page for expert advice on acing your exams.</a>
    </div>

<footer>
    Copyright © 2023 UniDiscover
</footer>
</body>
</html>





