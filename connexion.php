<!DOCTYPE html >
<html>
<head>
<link rel="stylesheet" href="style.css" type="text/css" />

<title>Connection</title>
</head>
<body id="body_bleu">

<div class="carre_connexion">

<?php

session_start(); 

?>

<form action="connecter.php" method="post" autocomplete="on">
    <label for="email">Email address :</label>
    <input type="text" id="email" name="email" required/></br></br></br>
    
    <label for="mdp">Password :</label>
    <input type="password" id="mdp" name="mdp" required/></br></br></br>
    
    <button id="oval-button-inscr" type="submit">Sign in</button>
</form>

<p></br> </br> Don't have an account? <a href="http://localhost/Projet/inscription.php">Click here</a></p>
</div>

<script>
	$(document).ready(function() {
		$('#submit').click(function() {
			var formData = {
				mail: $('#email').val(),
				mdp1: $('#mdp').val(),
			};

			$.ajax({
				type: 'GET',
				url: 'connecter.php',
				data: formData,
				dataType: 'json',
				success: function(response) {
					if (response.connected) {
						$('#message').html('<div style="color: green;">Connected successfully. Redirection in progress...</div>');
						setTimeout(function() {
							window.location.href = 'accueil.php'; // Redirection vers accueil.php
						}, 1000);
					} else {
						$('#message').html('<div style="color: red;">Connexion error : ' + response.message + '</div>');
					}
				},
				error: function() {
					console.error('Error in AJAX request.');
				}
			});
		});
	});
</script>
</body>
<footer>
Copyright © 2023 UniDiscover
</footer>
</html>