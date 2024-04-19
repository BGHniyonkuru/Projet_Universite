<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Contact</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #D7DCE3;
        }

        .container {
            background-color: #3C3B6E;
            color: white;
            padding-top: 10px;
            padding-bottom: 10px;
            display: flex;
            justify-content: center;
            align-items: center;
            width: 100%;
            margin-left: 0px;
            margin-right: 0px;
            max-width: none;
        }

        .container ul {
            list-style-type: none;
            margin: 0;
            padding: 0;
        }

        .container ul li {
            display: inline;
            margin-left: 20px;
        }

        .container ul li a {
            color: white;
            text-decoration: none;
        }

        .container ul li a:hover {
            color: #ccc;
        }

        #logo {
            height: 100px;
            width: 100px;
        }

        #logo2, #logo3 {
            height: 50px;
            width: 50px;
        }

        .section {
            background-color: #F4F5F7;
            padding: 20px;
            margin: 20px auto;
            border-radius: 10px;
            box-shadow: 0px 0px 10px 0px rgba(0,0,0,0.1);
            max-width: 800px;
        }

        .oval-button {
            margin-top: 20px;
            border-radius: 50%;
            background-color: #3C3B6E;
            color: white;
            padding: 15px 30px;
            border: none;
            cursor: pointer;
            font-size: 16px;
            width: 150px;
            display: block;
            margin: auto;
        }

        #formulaire {
            text-align: center;
            margin-top: 20px;
        }

        #comments_box textarea {
            width: 100%;
            padding: 10px;
            box-sizing: border-box;
            border-radius: 10px;
            border: 1px solid #ccc;
        }
        #name_email_container {
            display: flex;
            justify-content: space-around;
            align-items: center;
            margin-top: 20px;
            margin-bottom: 20px;
        }

        #name_email_container div {
            flex: 1;
            margin: 0 10px;
        }

        #name_email_container label {
            display: block;
            margin-bottom: 5px;
        }
        #name_email_container input {
            width: calc(100% - 150px); /* Ajustez la largeur pour tenir compte de la marge */
            padding: 5px;
            border-radius: 10px;
            border: 1px solid #ccc;
            margin-right: 10px; /* Ajoutez une marge à droite */
        }


    </style>
</head>


<body>

<div class="container">
    <a href= "accueil.php"><img id="logo" src="http://localhost/Projet/images/logo.png" alt="logo"></a>

    <ul>
        <li><a class= "bandeau" href="comparer.php">Compare</a></li>
        <li><a class= "bandeau" href="localiser.php">Map</a></li>
        <li><a class= "bandeau" href="predire.php">Predict</a></li>
        <li><a class= "bandeau" href="contact.php">Contact</a></li>
        <li><a class= "bandeau" href="search.php">Search</a></li>
    </ul>

    <a href= "favoris.php"><img id="logo2" src="http://localhost/Projet/images/favori.png" alt="logo"></a>
    <a href= "monCompte.php"><img id="logo3" src="http://localhost/Projet/images/monCompte.png" alt="logo"></a>
</div>
<div class="section">
    <p>Unidiscover was created by 5 students at <b>Paul Valéry Montpellier 3</b> in L3 MIASHS as part of a group project in project management.</p>
</div>

<div class="section">
    <p>Group Members :</p>

    <div style="display: flex; align-items: center;">
        <img src="membre1.jpg" alt="Membre 1" style="width: 50px; height: 50px; border-radius: 50%; margin-right: 10px;">
        <p><i><b>Elise COMMANDRE</i></b></p>
    </div>
    <div style="display: flex; align-items: center;">
        <img src="membre2.jpg" alt="Membre 2" style="width: 50px; height: 50px; border-radius: 50%; margin-right: 10px;">
        <p><i><b>Berline Cléria NIYONKURU</i></b></p>
    </div>

    <div style="display: flex; align-items: center;">
        <img src="images/photo.jpg" alt="Membre 3" style="width: 50px; height: 50px; border-radius: 50%; margin-right: 10px;">
        <p><i><b>Alvin INGABIRE</i></b></p>
    </div>

    <div style="display: flex; align-items: center;">
        <img src="membre1.jpg" alt="Membre 4" style="width: 50px; height: 50px; border-radius: 50%; margin-right: 10px;">
        <p><i><b>Grace Sidiqa PALENFO</i></b></p>
    </div>

    <div style="display: flex; align-items: center;">
        <img src="membre1.jpg" alt="Membre 5" style="width: 50px; height: 50px; border-radius: 50%; margin-right: 10px;">
        <p><i><b>Michele MEDOM SADEFO</i></b></p>
    </div>
</div>


<div class="section">
    <p><?php echo isset($_SESSION['client']) ? $_SESSION['client']['prenom'] . ', ' : ''; ?>Want to leave us a little message, a suggestion or anything else? Please go on.</p>

    <div id="formulaire">
        <form action="commentaires.php" method="post" autocomplete="off">
            <div id="name_email_container">
                <div>
                    <label for="name">Pseudo*:</label>
                    <input type="text" id="name" name="name" required />
                </div>

                <div>
                    <label for="email">Email*:</label>
                    <input type="email" id="email" name="email" required />
                </div>
            </div>

            <div id='comments_box'>
                <label for="comments">Comments*:</label><br>
                <textarea id="comments" name="comments" required cols="50" rows="5"></textarea>
            </div>

            <!-- Bouton d'envoi' -->
            <button type="submit" class="oval-button">Submit</button>
        </form>
        
    </div>
    <p style="font-size: 10px;">*:required fields</p>
</div>

<footer id="footer">
    Copyright © 2023 UniDiscover
</footer>

<?php
if (isset($_SESSION['message'])) {
    echo "<script>alert('" . $_SESSION['message'] . "');</script>";
    unset($_SESSION['message']);
}
?>

</body>
</html>
