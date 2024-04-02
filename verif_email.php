<?php
header('Content-Type: application/json');

require("bd.php");
$conn = getBD();


if (isset($_POST['email'])) {
    $email = $_POST['email'];

    // Échappez les données pour éviter les injections SQL
    $email = $conn->real_escape_string($email);

    // Requête pour vérifier l'existence de l'e-mail dans la base de données
    $query = "SELECT COUNT(*) as count FROM clients WHERE email = '$email'";
    $result = $conn->query($query);

    if ($result) {
        $row = $result->fetch_assoc();
        $emailExists = ($row['count'] > 0);
		$response = array('status' => 'success','message' => 'Adresse mail déjà existante');
        echo json_encode($response);
    } else {
        echo json_encode(['error' => 'Erreur lors de la requête SQL']);
    }
} else {
    echo json_encode(['error' => 'Paramètre manquant']);
}

?>

