<?php
session_start();

if (isset($_POST['universite_id']) && isset($_POST['client_id'])) {
    $universite_id = $_POST['universite_id'];
    $client_id = $_POST['client_id'];
	
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "projet_universite";

    // Créer une connexion à la base de données
    require("bd.php");
    $conn = getBD();

    // Vérifier la connexion
    if ($conn->connect_error) {
        die("La connexion a échoué : " . $conn->connect_error);
    }

    // Requête SQL pour insérer les données dans la table "favoris"
	// Récupérer le nom de l'université en fonction de son ID
	// Requête SQL préparée pour sélectionner le nom de l'université en fonction de son ID
	// Requête SQL préparée pour sélectionner le nom de l'université en fonction de son ID
	$sql_get_university_name = "SELECT name FROM universite WHERE id_universite = ?";
	$stmt = $conn->prepare($sql_get_university_name);

	// Lier les paramètres et exécuter la requête
	$stmt->execute([$universite_id]);

	// Récupérer le résultat
	$result = $stmt->fetch(PDO::FETCH_ASSOC);

	// Vérifier si des lignes ont été retournées
	if ($result) {
		// Récupérer le nom de l'université à partir du résultat
		$name = $result['name'];
	} else {
		// Gérer l'erreur si aucun résultat n'est retourné
		$name = "Nom inconnu";
	}
    $sql_insert_favorite = "INSERT INTO favoris (id_client, id_universite, name) VALUES ($client_id, $universite_id, '$name')";

    if ($conn->query($sql_insert_favorite) === TRUE) {
        // Réponse HTTP 200 pour indiquer le succès de l'opération
        http_response_code(200);
        echo "L'université a été ajoutée aux favoris avec succès.";
    } else {
        // Réponse HTTP 500 pour indiquer une erreur interne du serveur
        http_response_code(500);
        echo "Erreur lors de l'ajout de l'université aux favoris : " . $conn->error;
    }

    // Fermer la connexion à la base de données
    $conn->close();
} else {
    // Réponse HTTP 400 pour indiquer une mauvaise requête
    http_response_code(400);
    echo "Paramètres manquants.";

}

?>
