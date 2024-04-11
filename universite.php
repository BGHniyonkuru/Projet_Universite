<?php
session_start();
?>
<!DOCTYPE html >
<html>
	<head>
	<link rel="stylesheet" href="http://localhost/Projet/style.css" type="text/css" />
	<script src="https://cdn.plot.ly/plotly-latest.min.js"></script>
		<title>Universite</title>
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
			<a href= "accueil.php"><img id="logo" src="http://localhost/Projet/images/logo.png" alt="logo" ></a>

			<ul>
			  <li><a class= "bandeau" href="comparer.php">Compare</a></li>
			  <li><a class= "bandeau" href="localiser.php">Map</a></li>
			  <li><a class= "bandeau" href="predire.php" >Predict</a></li>
			  <li><a class= "bandeau" href="contact.php" >Contact</a></li>
			  <li><a class= "bandeau" href="search.php" >Search</a></li>
			</ul>
			<a href= "compte.php"><img id="logo2" src="http://localhost/Projet/images/favori.png" alt="logo"></a>
			<a href= "favori.php"><img id="logo3" src="http://localhost/Projet/images/monCompte.png" alt="logo"></a>
		</div>
	<body class="page-universite">
	
		<?php
		$servername = "localhost";
		$username = "root";
		$password = "";
		$dbname = "projet_universite";

		// Créer une connexion à la base de données
		$conn = new mysqli($servername, $username, $password, $dbname);

		// Vérifier la connexion
		if ($conn->connect_error) {
			die("Connection failed : " . $conn->connect_error);
		}

		// Récupérer l'identifiant de l'université depuis l'URL
		$universite_id = isset($_GET['id']) ? $_GET['id'] : "";

		// Requête SQL pour récupérer les informations de l'université spécifiée
		$sql = "SELECT image, name, description
				FROM universite u
				WHERE u.id_universite = $universite_id";

		$result = $conn->query($sql);
		if ($result) {
			// Assurez-vous qu'il y a des résultats
			if ($result->num_rows > 0) {
				$row = $result->fetch_assoc();
				$universite_name = $row['name'];
				$description=$row['description'];
				echo "<div id='container' style='background-color: #666666; padding: 5px; text-align: center;'><p id='nom_univ' style='color: white; display: inline;'>" . $universite_name . "</p><a href='http://localhost/Projet/search.php'><img src='http://localhost/Projet/images/loupe.png' alt='loupe' style='height: 20px; width: 20px; float: right; margin-left: 10px;'></a></div>";
				echo"<img src='http://localhost/Projet/images/etoile.jpg' alt='etoile' style='height: 30px; width: 30px; float: right;margin-top:10px;'>";
				if (!empty($row['image'])) {
					// Affichez l'image en utilisant la balise <img>
					echo "<img src='" . $row['image'] . "' alt='Image de l\'université' style='width: 10%; float: left; margin-left: 5%;margin-top:40px;'>";
				} else {
					// Si le chemin de l'image n'est pas défini, affichez un message ou une image par défaut
					echo "No image available.";
				}
				 // Affichez la description dans une div avec un fond gris clair
				echo "<div style='background-color: #D9D9D9; padding: 10px;margin-left: 10%;text-align: left; width: 70%;position:center; margin-left: 20%; overflow: hidden;margin-top:40px;color:black;'>";
				echo "<p id='description'>{$description}</p>";
				echo "</div>";
				
			} else {
				// Aucun résultat trouvé
				echo "No image found for this university.";
			}
		} else {
			// Erreur dans la requête
			echo "Request Error : " . $conn->error;
		}
		// Requête SQL pour récupérer les données de classement de l'université par année
		$sql_classement = "SELECT annee, rank_order
							FROM universite, classement,etre
							WHERE universite.id_universite = $universite_id AND etre.id_universite=universite.id_universite AND etre.id_classement=classement.id_classement 
							ORDER BY annee";
		$result_classement = $conn->query($sql_classement);

		// Vérifier si la requête a réussi
		if ($result_classement) {
			// Créer des tableaux pour stocker les données du graphique
			$annees = array();
			$classements = array();

			// Parcourir les résultats et stocker les données dans les tableaux
			while ($row_classement = $result_classement->fetch_assoc()) {
				$annees[] = $row_classement['annee'];
				$classements[] = $row_classement['rank_order'];
			}

			// Afficher le graphique
			echo "<div id='graph-container' style='width: 80%; margin: auto;'></div>";

			// Ajouter le script Plotly pour générer le graphique
			echo "<script>
					var trace = {
						x: " . json_encode($annees) . ",
						y: " . json_encode($classements) . ",
						type: 'scatter',
						mode: 'lines+markers',
						name: 'Evolution of the ranking'
					};

					var layout = {
						title: 'Évolution of the ranking of  - " . $universite_name . "',
						xaxis: {
							title: 'Year'
						},
						yaxis: {
							title: 'Ranking'
						}
					};

					Plotly.newPlot('graph-container', [trace], layout);
				  </script>";
		} else {
			// Afficher un message d'erreur si la requête a échoué
			echo "Ranking Request Error : " . $conn->error;
		}
		// Fermer la connexion à la base de données
		$conn->close();
		?>
	</body>
	<footer>
		Copyright © 2023 UniDiscover
	</footer>
</html>