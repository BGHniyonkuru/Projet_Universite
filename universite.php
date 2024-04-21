<?php
session_start();
?>
<!DOCTYPE html >
<html>
	<head>
	<link rel="stylesheet" href="style_universite.css" type="text/css" />
	<script src="https://cdn.plot.ly/plotly-latest.min.js"></script>
	<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
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
		<script>
		function ajouterAuxFavoris(universite_id) {
					// Récupérer l'identifiant du client depuis la session (vous devez implémenter cela côté serveur)
					var client_id = "<?php echo isset($_SESSION['client']['id']) ? $_SESSION['client']['id'] : 'null'; ?>";
					console.log('Valeur de $_SESSION[\'id\']:', "<?php echo isset($_SESSION['id']) ? $_SESSION['id'] : 'null'; ?>");
					console.log('client_id:', client_id);
					// Vérifier si l'utilisateur est connecté
					if (!client_id) {
						// Gérer l'erreur ici, par exemple, afficher un message à l'utilisateur
						console.log('Erreur : L\'utilisateur n\'est pas connecté.');
						return;
					}

					// Envoyer une requête AJAX pour ajouter l'université aux favoris
					var xhr = new XMLHttpRequest();
					xhr.open('POST', 'ajouter_aux_favoris.php', true);
					xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
					xhr.onreadystatechange = function() {
						if (xhr.readyState === 4 && xhr.status === 200) {
							// Afficher la réponse du serveur (peut être utilisé pour des messages de confirmation)
							console.log(xhr.responseText);
						}
					};
					xhr.send('universite_id=' + universite_id + '&client_id=' + client_id);
				}
		</script>
		
	</head>	
	
	<!-- bandeau en haut de l'écran -->
		<div class="container">
			<a href= "accueil.php"><img id="logo" src="/Projet_universite/images/logo.png" alt="logo" ></a>

			<ul>
				<li><a class= "bandeau" href="compare.php">Compare</a></li>
				<li><a class= "bandeau" href="localisation.php">Map</a></li>
				<li><a class= "bandeau" href="predire.php" >Predict</a></li>
				<li><a class= "bandeau" href="contact.php" >Contact</a></li>
				<li><a class= "bandeau" href="search_university.html" >Search</a></li>
			</ul>
			<a href= "favoris.php"><img id="logo2" src="images/favori.png" alt="logo"></a>
			<a href= "monCompte.php"><img id="logo3" src="images/monCompte.png" alt="logo"></a>
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
			die("La connexion a échoué : " . $conn->connect_error);
		}

		// Récupérer l'identifiant de l'université depuis l'URL
		$universite_id = isset($_GET['id']) ? $_GET['id'] : "";

		// Requête SQL pour récupérer les informations de l'université spécifiée
		$sql = "SELECT image, name, description, description2,description3
				FROM universite u
				WHERE u.id_universite = $universite_id";

		$result = $conn->query($sql);
		if ($result) {
			// Assurez-vous qu'il y a des résultats
			if ($result->num_rows > 0) {
				$row = $result->fetch_assoc();
				$universite_name = $row['name'];
				$description=$row['description'];
				$description2=$row['description2'];
				$description3=$row['description3'];
				echo "<div id='container1' style='background-color: #666666; text-align: center;'><p id='nom_univ' >" . $universite_name . "</p><a href='http://localhost/Projet_universite/search_university.html'><img id='loupe' src='images/loupe.png' alt='loupe' ></a></div>";
				echo "<button type='button' id='favori' onclick='ajouterAuxFavoris($universite_id)' style='border: none; background: none; cursor: pointer; float: right; margin-top: 10px;'>
						<img id='etoile' src='images/etoile.jpg' alt='etoile' style='height: 30px; width: 30px;'></button>";	
				if (!empty($row['image'])) {
					// Affichez l'image en utilisant la balise <img>
					echo "<img src='" . $row['image'] . "' alt='Image de l\'université' style='width: 10%; float: left; margin-left: 5%;margin-top:40px;'>";
				} else {
					// Si le chemin de l'image n'est pas défini, affichez un message ou une image par défaut 
					echo "Aucune image disponible.";
				}
				 // Affichez la description dans une div avec un fond gris clair
				echo "<div id='description-box' >";
				echo "<p id='description'>{$description}</p>";
				echo "<p id='description2'>{$description2}</p>";
				echo "<p id='description3'>{$description3}</p>";
				echo "</div>";
				
			} else {
				// Aucun résultat trouvé
				echo "Aucune image trouvée pour cette université.";
			}
		} else {
			// Erreur dans la requête
			echo "Erreur dans la requête : " . $conn->error;
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
			

			// Ajouter le script Plotly pour générer le graphique
			echo "<div style='height: 30px;'></div>
			<canvas id='myChart'  width='50' height='15' ></canvas>
			<div style='height: 50px;'></div>
			<script src='https://cdn.jsdelivr.net/npm/chart.js'></script>
			<script>
				var ctx = document.getElementById('myChart').getContext('2d');
				var myChart = new Chart(ctx, {
					type: 'line',
					data: {
						labels: " . json_encode($annees) . ",
						datasets: [{
							label: 'Évolution du classement',
							data: " . json_encode($classements) . ",
							backgroundColor: 'rgba(54, 162, 235, 0.2)',
							borderColor: 'rgba(54, 162, 235, 1)',
							borderWidth: 1,
							pointRadius: 5,
							pointBackgroundColor: 'rgba(54, 162, 235, 1)',
							pointBorderColor: '#fff',
							pointHoverRadius: 7,
							pointHoverBackgroundColor: '#fff',
							pointHoverBorderColor: 'rgba(54, 162, 235, 1)',
							pointHitRadius: 10,
							pointBorderWidth: 2
						}]
					},
					options: {
						scales: {
							xAxes: [{
								position:'top',
								scaleLabel: {
									display: true,
									labelString: 'Année'
								}
							}],
							yAxes: [{
								scaleLabel: {
									display: true,
									labelString: 'Classement'
								},
								ticks: {
									reverse: true
								}
							}]
						},
						title: {
							display: true,
							text: 'Évolution du classement de l\'université - " . $universite_name . "'
						}
					}
				});
				
				
				
			</script>";

		} else {
			// Afficher un message d'erreur si la requête a échoué
			echo "Erreur dans la requête de classement : " . $conn->error;
		}
		// Fermer la connexion à la base de données
		$conn->close();
		?>
	</body>
	<footer>
		Copyright © 2023 UniDiscover
	</footer>
</html>
