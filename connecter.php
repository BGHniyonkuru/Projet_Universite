<!DOCTYPE html >
<html>
	<head>
	<style>
		html {
			background-color: #3C3B6E; /* Fond bleu */
		}
		#connecter{
			background-color: #E5E5E5;
		}
		.error-message {
            color: red;
        }
		

</style>
		<title>Connected</title>
	</head>
	<body>
		<div id= 'connecter'>
		<?php
		session_start();

			$email=$_POST['email'];
			$mdp=$_POST['mdp'];
			require("bd.php");
			$bdd = getBD();
			$rep = $bdd->query("SELECT * FROM clients WHERE email = '$email' AND mdp = '$mdp'");
			if ($rep->rowCount() > 0) {
				$row = $rep->fetch();
				$_SESSION['client']= array(
				'id' => $row['id_client'],
				'nom' => $row['nom'],
				'prenom' => $row['prenom'],
				'email' => $row['email'],
				'mdp' => $row['mdp'])
				?><meta http-equiv="refresh" content="0;url=accueil.php"/><?php
			} 
			else {
				echo '<span class="error-message">Error: Incorrect password or email!!</span>';?>
				<p></br> <a href="connexion.php">Click here to return to login form</a></p>
			
			<?php }

		?>

		</div>

	</body>
</html>