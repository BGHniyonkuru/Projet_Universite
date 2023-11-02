<!DOCTYPE html >
<html>
	<head>
		<title>Nouveau Client</title>
	</head>
	<body>
		<?php		

		function enregistrer($nom, $prenom, $email, $mdp) {
		require("bd.php");
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

		if ($_SERVER["REQUEST_METHOD"] == "POST") {
			$nom = $_POST["nom"];
			$prenom = $_POST["prenom"];
			$email = $_POST["email"];
			$mdp = $_POST["mdp"];
			$mdp1 = $_POST["mdp1"];
			
			if($mdp!=$mdp1){
			header("Location: inscription.php");
			}
			elseif($nom != "" && $prenom != "" && $email != "" && $mdp != "" ) {
				enregistrer($nom, $prenom, $email, $mdp);
				header("Location: questionnaire.php");
				exit;
			}
			else{
				header("Location: inscription.php");
			}
		}?>

	</body>

</html>