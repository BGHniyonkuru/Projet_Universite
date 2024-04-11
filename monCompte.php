<?php 
session_start();

// Placez votre code de connexion à la base de données ici
require("bd.php");
$bdd = getBD();

// Récupérez les informations du client depuis la base de données
$requete = "SELECT nom, prenom FROM client WHERE id_client = :id_client";
$sql = $bdd->prepare($requete);
$sql->bindParam(':id_client', $_SESSION['id_client']);
/*$sql->execute();*/
$client_info = $sql->fetch(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css" type="text/css" />
   
    <title>Mon Compte</title>
    
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

        html, body {
            margin: 0;
            padding: 0;
            width: 100%;
            height: 100%;
        }


        .infos {
            width: 100%;
            max-width: 1200px;
            display: flex;
            flex-direction: row;
            justify-content: center;
            align-items: center;
            margin-top: 20px;
            min-height: 300px;
            
            background-color: #D9D9D9;
        }

        .info-container {
            
            display: flex;
            flex-direction: row;
            align-items: center;
            margin-right: 20px;
            width: 500px;
            margin-top: 10px;
        }

        .label {
            
            
            width: 120px;
        }
        .value{
            border: solid 1px grey;
            background-color: white;
            text-align: justify;
            flex-grow: 1; /* Permet à l'élément de s'étendre pour remplir l'espace disponible */
            flex-shrink: 1; /* Permet à l'élément de se rétrécir s'il n'y a pas assez de place */
        }

        #logo-between {
            display: block; /* Assurez-vous que l'image est un bloc */
            margin: 0 auto; /* Centre l'image horizontalement */
            /* margin: 0 auto; Ajustez la marge selon vos besoins */
            max-width: 100%; /* Assurez-vous que l'image ne dépasse pas la largeur de la fenêtre */
        }

        #logout-button {
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

        h1, .label {
            text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.5); /* Définissez l'ombre avec les valeurs appropriées */
        }
        
		
	</style>
    
</head>

<body id="body_mon_compte">
    
    <!-- Bandeau en haut de l'écran -->
    <div class="container">
        <a href= "accueil.php"><img id="logo" src="http://localhost/Projet/images/logo.png" alt="logo"></a>

        <ul>
        <li><a class= "bandeau" href="comparer.php">Compare</a></li>
        <li><a class= "bandeau" href="localiser.php">Map</a></li>
        <li><a class= "bandeau" href="predire.php" >Predict</a></li>
        <li><a class= "bandeau" href="contact.php" >Contact</a></li>
        <li><a class= "bandeau" href="search.php" >Search</a></li>
        </ul>
        <a href= "favoris.php"><img id="logo2" src="http://localhost/Projet/images/favori.png" alt="logo"></a>
        <a href= "monCompte.php"><img id="logo3" src="http://localhost/Projet/images/monCompte.png" alt="logo"></a>
    </div>

    <img id="logo-between" src="http://localhost/Projet/images/monCompte.png" alt="logo-between">
    
    <!-- Contenu principal -->
    <div class="infos">
        <div id="monCompte">

            <h1 style="text-align: center;"> PERSONAL INFORMATION :</h1>

            <div class="info-container">
                <div class="label">First Name</div>
                <div class="value"><?php echo $_SESSION['client']['nom']; ?></div>
            </div>

            <div class="info-container">
                <div class="label">Last Name</div>
                <div class="value"><?php echo $_SESSION['client']['prenom']; ?></div>
            </div>

            <div class="info-container">
                <div class="label">Last Diploma</div>
                <div class="value">Bac</div>
            </div>

            <div class="info-container">
                <div class="label">Wanted Fields</div>
                <div class="value">data science</div>
            </div>

        </div>
        
        
    </div>

    <!-- Bouton de déconnexion -->
    <form id="logout-form" action="logout.php" method="post">
        <button type="submit">Log out</button>
    </form>

    <!-- Footer -->
    <footer id="footer">
        Copyright © 2023 UniDiscover
    </footer>

    
    
</body>
</html>

<script>
    // Sélectionnez le footer
var footer = document.getElementById("footer");

// Ajoutez un gestionnaire d'événement pour détecter le défilement
window.addEventListener("scroll", function() {
    // Vérifiez si la position de défilement est à la fin de la page
    if ((window.innerHeight + window.scrollY) >= document.body.offsetHeight) {
        // Affichez le footer
        footer.style.display = "block";
    } else {
        // Masquez le footer
        footer.style.display = "none";
    }
});
</script>
