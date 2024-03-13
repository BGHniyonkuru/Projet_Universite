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
        <!--Style pour la liste -->
        ul {
            list-style-type: none; <!-- Supprime les puces de la liste -->
            padding-left: 0; <!-- Supprime le décalage par défaut de la liste -->
        }

        <!-- Style pour chaque élément de la liste -->
        li {
            position: relative; <!-- Position relative pour le positionnement absolu du pseudo-élément -->
            padding-left: 20px; <!-- Ajoute un espace pour le rectangle blanc -->
        }

        <!-- Style pour le rectangle blanc -->
        li::before {
            content: ''; <!-- Ajoute le contenu du pseudo-élément -->
            position: absolute; <!-- Position absolue pour positionner le rectangle -->
            left: 0; <!-- Positionne le rectangle à gauche de chaque élément de la liste -->
            top: 0; <!-- Alignement avec le haut de l'élément de liste-->
            width: 10px; <!-- Largeur du rectangle blanc -->
            height: 100%; <!-- Hauteur du rectangle égale à la hauteur de l'élément de liste -->
            background-color: white; <!-- Couleur du rectangle blanc -->
            z-index: -1; <!-- Assure que le rectangle est derrière le texte de l'élément de liste -->
        }
    </style>
	</head>
<body id="body_accueil">
	<div class="container">
			<a href= "accueil.php"><img id="logo" src="http://localhost/Projet/images/logo.png" alt="logo" ></a>

			<ul>
			  <li><a class= "bandeau" href="comparer.php">Compare</a></li>
			  <li><a class= "bandeau" href="localiser.php">Map to locate</a></li>
			  <li><a class= "bandeau" href="predire.php" >Prédict</a></li>
			  <li><a class= "bandeau" href="contact.php" >Contact</a></li>
			  <li><a class= "bandeau" href="search.php" >Search</a></li>
			</ul>
			<a href= "favoris.php"><img id="logo2" src="http://localhost/Projet/images/favori.png" alt="logo"></a>
			<a href= "monCompte.php"><img id="logo3" src="http://localhost/Projet/images/monCompte.png" alt="logo"></a>
		</div>
	
		
		<div  id="monCompte" style="border: 1px solid blue; padding: 10px;">
			<p style="text-align: center;"> PERSONAL INFORMATION :</p>
			
			<ul style="height: 100px; width: 30%; text-align: left; list-style-type: none;">
				<li style="margin: 10px;">First Name </li>
				<li style="margin: 10px;">Last Name </li>
				
				<li style="margin: 10px;">Last Diploma </li>
				<li style="margin: 10px;">Wanted Fields </li>
			</ul>
			
			<ul id="infos" style="margin-top: -123px; margin-left: 150px; width: 60%; text-align: left; list-style-type: none;">
				<li id='Nom' style="border: 1px solid grey; background-color: white; margin: 10px;" > Alvin</li>
				<li id='Prénom' style="border: 1px solid grey; background-color: white; margin: 10px;" > INGABIRE</li>
				<li id='Sexe' style="border: 1px solid grey; background-color: white; margin: 10px;" > M</li>
				<li id='Dernier Diplôme' style="border: 1px solid grey; background-color: white; margin: 10px;" > Bac</li>
				<li id='Domaine recherché' style="border: 1px solid grey; background-color: white; margin: 10px;" > data science</li>
			</ul>

			
		</div>
		
		
	<footer>
		Copyright © 2023 UniDiscover
	</footer>
	</div>
</body>

</html>