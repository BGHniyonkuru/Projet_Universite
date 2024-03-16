<?php
session_start();

// Stockez les résultats dans une variable de session
$_SESSION['resultats_requete'] = array();

// Vérifie si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupère les valeurs du formulaire
    $serie = $_POST["serie"];
    $budget = $_POST["budget"];
    $etat = $_POST["etatSelect"];
    $domaine_etude = $_POST["domainSelect"]; // Si vous avez un champ avec l'id domainInput

    

    // Exemple de connexion à une base de données et d'exécution de requête
    $servername = "localhost";
	$username = "root";
	$password = "";
	$dbname = "projet_universite";

    // Crée une connexion
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Vérifie la connexion
    if ($conn->connect_error) {
        die("La connexion a échoué : " . $conn->connect_error);
    }

	$sql="SELECT distinct universite.name FROM universite,ville WHERE ville.id_ville=universite.id_ville AND universite.price<= $budget AND ville.name_etat LIKE '%$etat%'  AND universite.domaine_etude LIKE '%$domaine_etude%';";
		
	$result = $conn->query($sql);

	// Vérifier si la requête a réussi
	if ($result === false) {
		die("La requête a échoué : " . $conn->error);
	}

	// Initialiser un tableau pour stocker les noms des universités
	$universites = array();

	// Traiter les résultats
	while ($row = $result->fetch_assoc()) {
		// Ajouter le nom de l'université au tableau
		$universites[] = array('id_universite' => $row['id_universite'], 'name' => $row['name']);
	}

	// Stocker les noms des universités dans la session
	$_SESSION['resultats_requete'] = $universites;


	header("Location: accueil.php");
	exit();

    // Fermez la connexion à la base de données
    $conn->close();
}
?>