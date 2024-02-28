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
	
	<!-- bandeau en haut de l'écran -->
	
		<div class="bandeau">
		<object data="bandeau.html" width="100%" height="100%">
		</object>
		</div>
	
		
		<div  id="monCompte" style="border: 1px solid blue; padding: 10px;">
			<p style="text-align: center;"> INFORMATIONS PERSONNELLES :</p>
			
			<ul style="height: 100px; width: 30%; text-align: left; list-style-type: none;">
				<li style="margin: 10px;">Nom </li>
				<li style="margin: 10px;">Prénom </li>
				<li style="margin: 10px;">Sexe </li>
				<li style="margin: 10px;">Dernier Diplôme </li>
				<li style="margin: 10px;">Domaine recherché </li>
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