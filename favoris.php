<?php
session_start();
// Connexion à la base de données
require("bd.php");
$conn = getBD();

?>

<html>
	<head>
	<link rel="stylesheet" href="style_universite.css" type="text/css" />
		<title>Favoris</title>
		<style>
			.bandeau{
            text-decoration: none;
			color:white;
			
			}

			#logo{
				margin-left:130px;
				margin-top:10px;
				height:100px;
				width:100px;
			}

			#logo2{
				margin-left:100px;
				margin-top:5px;
				height:50px;
				width:50px;
			}

			#logo3{
				margin-left:10px;
				margin-top:5px;
				height:50px;
				width:50px;
			}
		</style>

	</head>	
	
	    <!-- bandeau en haut de l'écran -->
		<div class="container">
			<a href= "accueil.php"><img id="logo" src="/Projet_universite/images/logo.png" alt="logo" ></a>

			<ul>
				<li><a class= "bandeau" href="comparaison.php">Compare</a></li>
				<li><a class= "bandeau" href="localisation.php">Map</a></li>
				<li><a class= "bandeau" href="predire.php" >Prédict</a></li>
				<li><a class= "bandeau" href="contact.php" >Contact</a></li>
				<li><a class= "bandeau" href="search_university.html" >Search</a></li>
			</ul>
			<a href= "favoris.php"><img id="logo2" src="/Projet_universite/images/favori.png" alt="logo"></a>
			<a href= "monCompte.php"><img id="logo3" src="/Projet_universite/images/monCompte.png" alt="logo"></a>
		</div>
        </html>

    </head>


    <?php

        // Vérifier si l'utilisateur est connecté
        if (!isset($_POST['client_id'])) {
            die('Vous devez être connecté pour voir vos favoris.');
        }

        $client_id = $_POST['client_id'];
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "projet_universite";

        
        // Récupérer les universités favorites
        $sql = "SELECT * FROM favoris WHERE id_client = $client_id";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            echo "<h1>Mes Universités Favorites</h1>";
            echo "<ul>";
            while($row = $result->fetch_assoc()) {
                echo "<li>" . htmlspecialchars($row['name']) . "</li>";
            }
            echo "</ul>";
        } else {
            echo "Aucune université favorite enregistrée.";
        }

        $conn->close();
    ?>
</html>
