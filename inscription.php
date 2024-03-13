<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>
    <link rel="stylesheet" href="style.css">
</head>

<body id="body_bleu">

    <div class="carre_inscr">
        <p>Welcome to <i><b>Unisearch</b>!</i></p>
        <p>Already registered?, <a href="http://localhost/Projet/connexion.php">click here</a></p>

        <form id="inscription-form" method="post" autocomplete="on">
            
            <label for="prenom">First Name :</label>
            <input type="text" id="prenom" name="prenom" required><br><br>

            <label for="nom">Last Name :</label>
            <input type="text" id="nom" name="nom" required><br><br>

            <label for="email">Email address :</label>
            <input type="email" id="email" name="email" required><br><br>

            <label for="mdp">Password :</label>
            <input type="password" id="mdp" name="mdp" required><br><br>

            <label for="mdp1">Password Confirmation :</label>
            <input type="password" id="mdp1" name="mdp1" required><br><br>

            <button id="oval-button-inscr" type="submit">Sign up</button>
        </form>

        <div id="message" class="error-msg"></div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="fichier.js"></script>
</body>

<footer>
    Copyright © 2023 UniDiscover
</footer>

</html>
