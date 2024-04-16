<?php
session_start();

require("bd.php");

function enregistrer($nom, $prenom, $email, $mdp)
{
    $bdd = getBD();
    $requete = $bdd->prepare("INSERT INTO clients (nom, prenom, email, mdp) VALUES (:nom, :prenom, :email, :mdp)");
    $requete->execute(
        array(
            "nom" => $nom,
            "prenom" => $prenom,
            "email" => $email,
            "mdp" => $mdp,
        )
    );
}

$response = array(); // Initialisation du tableau de réponse

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom = $_POST["nom"];
    $prenom = $_POST["prenom"];
    $email = $_POST["email"];
    $mdp = $_POST["mdp"];
    $mdp1 = $_POST["mdp1"];

    // Vérification s'il y a un mail identique existant
    $bdd = getBD();
    $sql = "SELECT * FROM clients WHERE email= :email";
    $requete1 = $bdd->prepare($sql);
    $requete1->bindParam(":email", $email);
    $requete1->execute();
    $ligne = $requete1->fetch();

    if ($ligne) {
        $response["status"] = "error";
        $response["message"] = "Email already exists";
    } elseif ($mdp != $mdp1) {
        $response["status"] = "error";
        $response["message"] = "Passwords do not match";
    } elseif ($nom != "" && $prenom != "" && $email != "" && $mdp != "") {
        enregistrer($nom, $prenom, $email, $mdp);
        $response["status"] = "success";
        $response["redirect"] = "questionnaire.php"; // Indiquez le chemin de redirection
    }
}

// Renvoyer la réponse JSON
echo json_encode($response);
?>
