<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Contact</title>
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
            .envoi{
                border-radius: 50%; /* Pour une forme ovale */
                margin: 0 auto;
                background-color: #3C3B6E; /* Couleur de fond bleu royal */
                color: white; /* Couleur du texte */
                padding: 10px 20px; /* Espacement interne */
                border: none; /* Pas de bordure */
                cursor: pointer; /* Curseur pointeur au survol */
                margin-top: 20px; /* Espacement depuis la classe .infos */
                font-size: 16px; /* Taille de la police */
                display: flex;
                justify-content: center;
                align-items: center;
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
<body>
    
    <div>
        <p>Want to leave us a little message, a suggestion or anything else? Please go on</p>

    </div>

    <!-- Présentation des créateurs -->
    <div>
        <p>Site Unidiscover créé par 5 étudiants en L3 MIASHS à Paul Valéry Montpellier dans le cadre d'un projet de groupe en gestion de projet.</p>
    </div>

    <!-- Photos et noms des membres du groupe -->
    <div>
        <p>Membres du groupe :</p>

        <div style="display: flex; align-items: center;">
            <img src="membre1.jpg" alt="Membre 1" style="width: 50px; height: 50px; border-radius: 50%; margin-right: 10px;">
            <p><i><b>Elise COMMANDRE</i></b></p>
        </div>
        <div style="display: flex; align-items: center;">
            <img src="membre2.jpg" alt="Membre 2" style="width: 50px; height: 50px; border-radius: 50%; margin-right: 10px;">
            <p><i><b>Berline Cléria Niyonkuru</i></b></p>
        </div>

        <div style="display: flex; align-items: center;">
            <img src="images/photo.jpg" alt="Membre 3" style="width: 50px; height: 50px; border-radius: 50%; margin-right: 10px;">
            <p><i><b>Alvin INGABIRE</i></b></p>
        </div>

        <div style="display: flex; align-items: center;">
            <img src="membre1.jpg" alt="Membre 4" style="width: 50px; height: 50px; border-radius: 50%; margin-right: 10px;">
            <p><i><b>Grace PALENFO SIDIQA</i></b></p>
        </div>

        <div style="display: flex; align-items: center;">
            <img src="membre1.jpg" alt="Membre 5" style="width: 50px; height: 50px; border-radius: 50%; margin-right: 10px;">
            <p><i><b>Michele MEDOM SADEFO</i></b></p>
        </div>
        
    </div>

    <div id="formulaire">
        <form action="commentaires.php" method="post" autocomplete="off">
            <div id="name_email_container" style="display: flex;">
                <div id="last_name_box" style="flex: 1;">
                    <label for="name">Last Name*:</label>
                    <input type="text" id="name" name="name" required />
                </div>

                <div id="email_box" style="flex: 1; margin-left: 20px;">
                    <label for="email">Email*:</label>
                    <input type="text" id="email" name="email" required /><br /><br />
                </div>
            </div>

            <div id='comments_box'>
                <label for="comments">Comments*:</label><br>
                <textarea id="comments" name="comments" required cols="50" rows="5"></textarea><br /><br />
            </div>

            <!-- Bouton d'envoi' -->
            <div class="oval-button">
                <button type="submit">Submit</button>
            </div>
        </form>
    </div>


    
    
    





    <!-- Footer -->
    <footer id="footer">
        Copyright © 2023 UniDiscover
    </footer>
</body>
</html>