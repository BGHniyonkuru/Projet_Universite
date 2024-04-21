<?php
session_start();
include('bd.php');

$conn = getBdd();

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Vérification si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_client= $_SESSION['client']['id'];
    $nom = trim($_POST['name']);
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $commentaire = trim($_POST['comments']);

    if (empty($nom) || !filter_var($email, FILTER_VALIDATE_EMAIL) || empty($commentaire)) {
        $_SESSION['alert'] = ['message' => "Please fill in all fields correctly.", 'type' => "error"];
    } else {
        $sql = "INSERT INTO commentaires (id_client, email, comments) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        if ($stmt === false) {
            die("MySQL prepare error: " . $conn->error);
        }

        $stmt->bind_param("sss", $id_client, $email, $commentaire);
        if ($stmt->execute()) {
            $_SESSION['alert'] = ['message' => "Thank you for your comments, $nom!", 'type' => "success"];
        } else {
            $_SESSION['alert'] = ['message' => "Error sending comments: " . $stmt->error, 'type' => "error"];
        }
        $stmt->close();
    }
    $conn->close();
    header("Location: contact.php");  // Redirection vers la page de contact
    exit();
}
?>

<?php
/*session_start();

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

$conn->close();*/
?>
