<?php
session_start();

include('bd.php');

// Création de la connexion
$conn = getBdd();

// Vérification de la connexion
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Vérification si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_client = isset($_SESSION['client']) ? $_SESSION['client']['id'] : '0';
    $comments = isset($_POST['comments']) ? $conn->real_escape_string($_POST['comments']) : '';
    $email = isset($_POST['email']) ? $conn->real_escape_string($_POST['email']) : '';

    // Requête SQL pour insérer des données
    $sql = "INSERT INTO commentaires (id_client, comments, email) VALUES (?, ?, ?)";

    // Préparation de la requête
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die("MySQL prepare error: " . $conn->error);
    }

    // Liaison des paramètres
    $stmt->bind_param("iss", $id_client, $comments, $email);

    // Exécution de la requête
    if ($stmt->execute()) {
        $_SESSION['message'] = "Thank you for your comment!";
    } else {
        $_SESSION['message'] = "Error sending comments: " . $stmt->error;
    }

    $stmt->close();
    header("Location: contact.php");  // Redirect back to the contact page
    exit();
}

$conn->close();
?>
