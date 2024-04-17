<?php
// Informations de connexion à la base de données
require("bd.php");
$conn = getBD();


// Vérifier la connexion
if ($conn->connect_error) {
    // Arrêter l'exécution du script en cas d'échec de connexion
    die("La connexion a échoué : " . $conn->connect_error);
}

// Récupérer le terme de recherche depuis la requête GET
$searchTerm = isset($_GET['q']) ? $conn->real_escape_string($_GET['q']) : "";
// Construire la requête SQL
$sql = "WITH RankedClassements AS (
          SELECT
            u.id_universite,
            u.name AS universite_name,
            u.domaine_etude,
            v.name AS ville_name,
            c.rank_order,
            c.scores_overall,
            c.annee,
            u.image,
            ROW_NUMBER() OVER (PARTITION BY u.id_universite ORDER BY c.annee DESC) AS rnk
          FROM
            universite u
            LEFT JOIN ville v ON u.id_ville = v.id_ville
            LEFT JOIN etre e ON u.id_universite = e.id_universite
            LEFT JOIN classement c ON e.id_classement = c.id_classement
          WHERE
            u.name LIKE '%$searchTerm%' OR v.name LIKE '%$searchTerm%'
        )
        SELECT
          id_universite,
          universite_name,
          domaine_etude,
          ville_name,
          rank_order,
          scores_overall,
          annee,
          image
        FROM
          RankedClassements
        WHERE
          rnk = 1";

// Exécuter la requête SQL
$result = $conn->query($sql);

if ($result) {
    // Initialiser un tableau pour stocker les résultats
    $universities = array();

    // Récupérer les résultats et les ajouter au tableau
    while ($row = $result->fetch_assoc()) {
        $universities[] = array(
            'id_universite' => htmlspecialchars($row['id_universite']),
            'universite_name' => htmlspecialchars($row['universite_name']),
            'domaine_etude' => htmlspecialchars($row['domaine_etude']),
            'ville_name' => htmlspecialchars($row['ville_name']),
            'rank_order' => htmlspecialchars($row['rank_order']),
            'scores_overall' => htmlspecialchars($row['scores_overall']),
            'annee' => htmlspecialchars($row['annee']),
            'image_link' => htmlspecialchars($row['image'])
        );
    }

    // Retourner le tableau en tant que réponse JSON
    echo json_encode($universities);
} else {
    // Retourner un message d'erreur en JSON
    echo json_encode(array('error' => 'Erreur dans la requête : ' . $conn->error));
}

// Fermer la connexion à la base de données
$conn->close();
?>
