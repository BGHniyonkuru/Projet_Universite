<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "projet_universite";

// Créer une connexion à la base de données
$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifier la connexion
if ($conn->connect_error) {
    die("La connexion a échoué : " . $conn->connect_error);
}

// Récupérer la valeur de recherche depuis la requête GET
$searchTerm = isset($_GET['q']) ? $conn->real_escape_string($_GET['q']) : "";

// Requête SQL pour rechercher des universités dans la ville spécifiée ou avec le nom spécifié
$sql = "SELECT u.id_universite, u.name AS universite_name, v.name AS ville_name
        FROM universite u
        LEFT JOIN ville v ON u.id_ville = v.id_ville
        WHERE u.name LIKE '%$searchTerm%' OR v.name LIKE '%$searchTerm%'";


$result = $conn->query($sql);

if ($result) {
    // Afficher les résultats
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
		echo "<p><a href='universite.php?id=" . $row['id_universite'] . "'>" . $row['universite_name'] . "</a> - Ville : " . $row['ville_name'] . "</p>";
        }
    } else {
        echo "Aucun résultat trouvé.";
    }
} else {
    echo "Erreur dans la requête : " . $conn->error;
}

// Fermer la connexion à la base de données
$conn->close();
?>

