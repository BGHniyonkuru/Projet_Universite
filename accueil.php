<?php 
session_start();
?>
<!DOCTYPE html >
<html>
	<head>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="stylesheet" href="style.css" type="text/css" />

		<title>Accueil</title>
		<style>
			.bandeau{text-decoration: none;
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
			#searchResults{
				margin-left:5px;
			}
	</style>
	</head>
<body id="body_accueil">
	<div class="container">

			<a href= "accueil.php"><img id="logo" src="images/logo.png" alt="logo" ></a>

			<ul>
			  <li><a class= "bandeau" href="comparer.php">Compare</a></li>
			  <li><a class= "bandeau" href="localiser.php">Map to locate</a></li>
			  <li><a class= "bandeau" href="predire.php" >Prédict</a></li>
			  <li><a class= "bandeau" href="contact.php" >Contact</a></li>
			  <li><a class= "bandeau" href="search.php" >Search</a></li>
			</ul>
			<a href= "favoris.php"><img id="logo2" src="images/favori.png" alt="logo"></a>
			<a href= "monCompte.php"><img id="logo3" src="images/monCompte.png" alt="logo"></a>
		</div>
	

		
		<div>
			<p id ="titre"> Top 3 2023 best universities</p>
		</div>
		
		<div id= 'podium'>

		<table class= "tableau">

			<tr>
				
				<th> Name </th>
				<th> Mondial rank </th>
				<th> Year </th>
			
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

</html>