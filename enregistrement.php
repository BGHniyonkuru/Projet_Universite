<!DOCTYPE html >
<html>
	<head>
		<title>Nouveau Client</title>
	</head>
	<body>
		<?php	
		
		require("bd.php");
		function enregistrer($nom, $prenom, $email, $mdp) {
			
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

			//vérifier s'il ya un mail identique existant
			$bdd= getBD();
			$sql = "SELECT * FROM clients WHERE email= :email";
			$requete = $bdd->prepare($sql);
			$requete->bindParam(":email", $email);
			$requete->execute();
			$ligne = $requete->fetch();
			
			if( $mdp != $mdp1){
				echo json_encode(array("status" => "error"));
			}if($nom != "" && $prenom != "" && $email != "" && $mdp != "" ) {
				enregistrer($nom, $prenom, $email, $mdp);
				header("Location: questionnaire.php");
				echo json_encode(array("status" => "success"));
			}
			
		}?>

	</body>

</html>