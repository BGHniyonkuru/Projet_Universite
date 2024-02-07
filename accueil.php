<?php 
session_start();
?>
<!DOCTYPE html >
<html>
	<head>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="stylesheet" href="style.css" type="text/css" />

		<title>Accueil</title>
	</head>
<body id="body_accueil">
	<div class="container">
			<a href= "accueil.php"><img id="logo" src="http://localhost/Projet/images/logo.png" alt="logo" ></a>

			<ul>
			  <li><a class= "bandeau" href="comparer.php">Comparer</a></li>
			  <li><a class= "bandeau" href="localiser.php">Localiser</a></li>
			  <li><a class= "bandeau" href="predire.php" >Prédire</a></li>
			  <li><a class= "bandeau" href="contact.php" >Contact</a></li>
			  <li><a class= "bandeau" href="search.php" >Rechercher</a></li>
			</ul>
			<a href= "favoris.php"><img id="logo2" src="http://localhost/Projet/images/favori.png" alt="logo"></a>
			<a href= "monCompte.php"><img id="logo3" src="http://localhost/Projet/images/monCompte.png" alt="logo"></a>
		</div>
	
<<<<<<< HEAD
		
		<div>
			<p id ="titre"> Top 3 2023 best universities</p>
		</div>
		
		<div id= 'podium'>

		<table class= "tableau">

			<tr>
				
				<th> nom </th>
				<th> rang mondial </th>
				<th> annee </th>
			
			</tr>
			<?php
				require("bd.php");
				$bdd = getBD();
				$requete="SELECT name, rank_order, annee FROM universite,classement,etre where universite.id_universite=etre.id_universite and etre.id_classement=classement.id_classement and classement.id_classement IN( SELECT id_classement FROM classement where annee=2023 and rank_order BETWEEN 0 and 5)";
				$sql = $bdd-> prepare($requete);
				$sql->execute();

				while ($row = $sql->fetch()) {
					echo "<tr>";
					echo "<td>" . $row['name'] . "</td>\n";
					echo "<td>" . $row['rank_order'] . "</td>\n";
					echo "<td>" . $row['annee'] . "</td>\n";
					echo "</tr>";
				}
			?>
			</table>
		</div>
	<footer>
		Copyright © 2023 UniDiscover
	</footer>
	</div>
</body>

=======
	<body>
		<!-- bandeau en haut de l'écran -->
		<div class="container">
			<a href= "accueil.php"><img id="logo" src="http://localhost/Projet/images/logo.png" alt="logo" ></a>

			<ul>
			  <li><a class= "bandeau" href="comparer.php">Comparer</a></li>
			  <li><a class= "bandeau" href="localiser.php">Localiser</a></li>
			  <li><a class= "bandeau" href="predire.php" >Prédire</a></li>
			  <li><a class= "bandeau" href="contact.php" >Contact</a></li>
			  <li><a class= "bandeau" href="search.php" >Rechercher</a></li>
			</ul>
			<a href= "compte.php"><img id="logo2" src="http://localhost/Projet/images/favori.png" alt="logo"></a>
			<a href= "favori.php"><img id="logo3" src="http://localhost/Projet/images/monCompte.png" alt="logo"></a>
		</div>
	</body>
<footer>
Copyright © 2023 UniDiscover
</footer>
>>>>>>> 01344d7e8602f68c0eeaaa40305b5b227574c4a9
</html>