<?php
require_once("bd.php");
$bdd = getBD();
$searchQuery = $_GET['search'] ?? '';

$sql = "SELECT v.id_ville, v.name AS ville, v.latitude, v.longitude, v.name_etat, u.id_universite,
    u.id_ville AS id_ville_universite, u.name AS university_name, u.domaine_etude, 
    u.`acceptance_rate(%)` AS acceptance_rate, price
    FROM ville v
    JOIN universite u ON v.id_ville = u.id_ville";
$result = $bdd->prepare($sql);
$result->execute();

$universities = array();
if ($result->rowCount() > 0) {
    while($row = $result->fetch(PDO::FETCH_ASSOC)) {
        $universities[] = $row;
    }
}

// Fermeture de la connexion à la base de données
$bdd = null;

// Renvoi des données au format JSON
header('Content-Type: application/json');
echo json_encode($universities);
?>