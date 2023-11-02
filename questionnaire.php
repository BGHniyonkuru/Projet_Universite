<!DOCTYPE html >
<html>
<head>
<meta http-equiv="Content-Type"
content="text/html; charset=UTF-8" />
<link rel="stylesheet" href="http://localhost/Projet/style.css" type="text/css" />

<title>Questionnaire</title>
</head>

<body id="body_bleu">

<div class="carre_questionnaire">
<p>Voici un petit questionnaire pour vous suggérer ce qui vous correspond</a></p>


<form action="enr_questionnaire.php" method="post" autocomplete="on">
		Homme :
		<input type="radio" name="genre" value="H"><br />
		Femme :
		<input type="radio" name="genre" value="F"></br></br>
		
		<label for "diplome">Dernier diplôme obtenu :</label>
		<input type="text" id="diplome" name="diplome" required"/></br></br>
		
		<label for "prenom">Série :</label>
		<input type="text" id="serie" name="serie" required"/></br></br>

		<label for "email">Mention :</label>
		<input type="text" id="mention" name="mention" required"/></br></br>
		
		<label for "mdp">Domaine recherché :</label>
		<input type="text" id="domaine" name="domaine" required"/></br></br>
		
		<label for "mdp1">Budget académique prévu :</label>
		<input type="txt" id="budget" name="budget" required"/></br></br>
		
		<label for "mdp1">Etat de préférence :</label>
		<input type="txt" id="etat" name="etat" required"/></br></br>
		
		<button id="oval-button-inscr" type="submit" >Valider</button></br></br>
		<a href="http://localhost/Projet/accueil.php">Ignorer le questonnaire</a>
 </form>
  
</div>

</body>

<footer>
Copyright © 2023 UniDiscover
</footer>
</html>
