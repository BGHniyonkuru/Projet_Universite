<?php
// Paramètres de connexion à la base de données
require("bd.php");
$conn = getBD();



// Vérification de la connexion
if ($conn->connect_error) {
    die("La connexion a échoué : " . $conn->connect_error);
}

// Récupération du terme de recherche depuis la requête GET
$searchTerm = isset($_GET['q']) ? $conn->real_escape_string($_GET['q']) : "";

// Construction de la requête SQL
$sql = "SELECT `name` FROM `universite` WHERE `name` LIKE '%$searchTerm%'";
$result = $conn->query($sql);

// Vérification du résultat de la requête
if ($result) {
    // Initialisation d'un tableau pour stocker les résultats
    $universities = array();

    // Parcours des résultats et ajout au tableau
    while ($row = $result->fetch_assoc()) {
        $universities[] = htmlspecialchars($row['name']);
    }

    // Retour du tableau en tant que réponse JSON
    echo json_encode($universities);
} else {
    // Retour d'un message d'erreur en tant que réponse JSON
    echo json_encode(array('error' => 'Erreur dans la requête : ' . $conn->error));
}

// Fermeture de la connexion à la base de données
$conn->close();
?>
