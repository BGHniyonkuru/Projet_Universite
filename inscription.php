<!DOCTYPE html >
<html>
<head>
<meta http-equiv="Content-Type"
content="text/html; charset=UTF-8" />
<link rel="stylesheet" href="http://localhost/Projet/style.css" type="text/css" />

<title>Inscritpion</title>
</head>

<body id="body_bleu">

<div class="carre_inscr">
<p>Bienvenue sur Unisearch! </br> Avez-vous déjà un compte? Si oui, <a href="http://localhost/Projet/connexion.php">cliquez ici</a></p>


<form action="enregistrement.php" method="post" autocomplete="on">
		<label for "nom">Nom :</label>
		<input type="text" id="nom" name="nom" required"/></br></br>
		
		<label for "prenom">Prénom :</label>
		<input type="text" id="prenom" name="prenom" required"/></br></br>

		<label for "email">Adresse email :</label>
		<input type="text" id="email" name="email" required"/></br></br>
		
		<label for "mdp">Mot de passe :</label>
		<input type="password" id="mdp" name="mdp" required"/></br></br>
		
		<label for "mdp1">Confirmation du mot de passe :</label>
		<input type="password" id="mdp1" name="mdp1" required"/></br></br>
		
		<button id="oval-button-inscr" type="submit" >S'inscrire</button>
 </form>
</div>

</body>

<footer>
Copyright © 2023 UniDiscover
</footer>
</html>
