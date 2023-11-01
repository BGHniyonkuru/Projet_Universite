<!DOCTYPE html >
<html>
	<head>
		<title>Connecter</title>
	</head>
	<body>
<?php
session_start();

		   $email=$_POST['email'];
			$mdp=$_POST['mdp'];
			require("C:\wamp64\www\Projet\bd.php");
			$bdd = getBD();
			$rep = $bdd->query("SELECT * FROM clients WHERE mail = '$email' AND mdp = '$mdp'");
			if ($rep->rowCount() > 0) {
				$row = $rep->fetch();
				$_SESSION['client']= array(
				'id' => $row['id_client'],
				'nom' => $row['nom'],
				'prenom' => $row['prenom'],
				'email' => $row['mail'],
				'mdp' => $row['mdp'],)
				?><meta http-equiv="refresh" content="0;url=http://localhost/Commandr%C3%A9/accueil.php"/><?php
			} 
			else {
			echo 'erreur';
			}

?>

</body>
</html>