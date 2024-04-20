<?php
session_start();


if (isset($_POST['universite_id']) && isset($_POST['client_id'])) {
    $universite_id = $_POST['universite_id'];
    $client_id = $_POST['client_id'];
    $name = $universite_name;

    // Créer une connexion à la base de données
    require("bd.php");
    $conn = getBD();

    // Vérifier la connexion
    if ($conn->connect_error) {
        die("La connexion a échoué : " . $conn->connect_error);
    }

    
    $sql = "INSERT INTO favoris (name, id_universite, id_client) VALUES (:name, :id_universite, :id_client)";
    $stmt = $conn->prepare($sql);
    $stmt->execute(
        array(
            "name" => $name,
            "id_universite" => $universite_id,
            "id_client" => $client_id,
   
        )
    );

    if ($stmt) {
        echo "Université ajoutée aux favoris.";
    } else {
        echo "Erreur : " . $stmt->error;
    }
    $stmt->close();
    $conn->close();
/*
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
}*/
}
?>
