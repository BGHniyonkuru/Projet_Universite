<!DOCTYPE html >
<html>
<head>
<link rel="stylesheet" href="style.css" type="text/css" />

<title>Connexion</title>
</head>
<body id="body_bleu">

<div class="carre_connexion">

<?php

session_start(); 

?>

<form action="connecter.php" method="post" autocomplete="on">
		<label for "nom">Adress email :</label>
		<input type="text" id="nom" name="nom" required"/></br></br></br>
		
		<label for "nom">Mot de passe :</label>
		<input type="password" id="nom" name="nom" required"/></br></br></br>
		
		<button id="oval-button-inscr" type="submit" >S'inscrire</button>
</form>
<p></br> </br> Vous n'avez pas de compte? <a href="inscription.php">Cliquez ici</a></p>
</div>

</body>
<footer>
Copyright © 2023 UniDiscover
</footer>
</html>