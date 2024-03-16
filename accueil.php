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
	<script>
        // JavaScript pour afficher la fenêtre modale
        function afficherResultats() {
            // Récupérer les résultats de la session PHP
            <?php
            session_start();
            $resultats = $_SESSION['resultats_requete'] ?? [];
            ?>
			console.log('Résultats de la requête :', <?php echo json_encode($resultats); ?>);

            // Créer une div pour afficher les résultats
            var modal = document.createElement('div');
            modal.style.position = 'fixed';
            modal.style.top = '50%';
            modal.style.left = '50%';
            modal.style.transform = 'translate(-50%, -50%)';
            modal.style.backgroundColor = '#FFF';
            modal.style.padding = '20px';
            modal.style.border = '1px solid #000';
            modal.style.zIndex = '9999';
            modal.innerHTML = '<h2>Résultats de la recherche :</h2>';

            // Ajouter chaque résultat dans la div
            <?php foreach ($resultats as $resultat) { ?>
                var universiteId = '<?php echo $resultat['id_universite']; ?>';
				var universite = '<?php echo $resultat['name']; ?>';
                var lien = document.createElement('a');
				lien.href = 'http://localhost/Projet/universite.php?id=' + encodeURIComponent(universiteId);
                lien.textContent = universite;
                lien.style.display = 'block';
                lien.style.marginBottom = '10px';
                modal.appendChild(lien);
            <?php } ?>

            // Ajouter un bouton de fermeture à la fenêtre modale
            var closeButton = document.createElement('button');
            closeButton.textContent = 'Fermer';
            closeButton.onclick = function() {
                document.body.removeChild(modal);
            };
            modal.appendChild(closeButton);

            // Ajouter la div à la page
            document.body.appendChild(modal);
        }
    </script>
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
	
		<!-- Bouton pour afficher les résultats -->
		<button onclick="afficherResultats()">Afficher les résultats</button>
		
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