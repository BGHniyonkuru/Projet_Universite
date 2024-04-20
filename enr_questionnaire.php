<?php
session_start();

require('bd.php');
// Stockez les résultats dans une variable de session


// Vérifie si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupère les valeurs du formulaire
	$client_id = isset($_SESSION['client']) ? $_SESSION['client']["id"] : '0';
	$diplome = $_POST["diplome"];
	$type_univ = $_POST["type_univ"];
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

	// Stockez les résultats dans une variable de session
	

	function enregistrer_questionnaire($client_id, $diplome, $type_univ, $budget, $etat, $domaine_etude) {
		$bdd = getBD();
		$requete = $bdd->prepare("INSERT INTO recommandations (id_client, diplome, type_univ, budget, etat, domaine) 
								VALUES (:id_client, :diplome, :type_univ, :budget, :etat, :domaine_etude)");
		$requete->execute(array(
			"id_client" => $client_id,
			"diplome" => $diplome,
			"type_univ" => $type_univ,
			"budget" => $budget,
			"etat" => $etat,
			"domaine_etude" => $domaine_etude
		));
	}	

	$sql="SELECT distinct universite.name, universite.id_universite FROM universite,ville WHERE ville.id_ville=universite.id_ville AND universite.price<= $budget AND ville.name_etat LIKE '%$etat%'  AND universite.domaine_etude LIKE '%$domaine_etude%'  AND universite.description LIKE'%$type_univ%';";
		
	$result = $conn->query($sql);

	// Vérifier si la requête a réussi
	if ($result === false) {
		die("La requête a échoué : " . $conn->error);
	}

	// Initialiser un tableau pour stocker les noms des universités
	$universites = array();

	// Traiter les résultats
	if ($result->num_rows > 0) {
		while ($row = $result->fetch_assoc()) {

			// Ajouter le nom de l'université au tableau
			$universites[] = array('id_universite' => $row['id_universite'], 'name' => $row['name']);
		}
	} else {
		// Aucun résultat trouvé, vous pouvez afficher un message à l'utilisateur ou effectuer une action appropriée
	}

	enregistrer_questionnaire($client_id, $diplome, $type_univ, $budget, $etat, $domaine_etude);
	header("Location: accueil.php");
	exit();

    // Fermez la connexion à la base de données
    $conn->close();
}
?>