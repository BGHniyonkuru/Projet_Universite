<!DOCTYPE html >
<html>
<head>
<meta http-equiv="Content-Type"content="text/html; charset=UTF-8" />
<link rel="stylesheet" href="style.css" type="text/css" />

<style>
	
	body {
		
		position: relative;
		background-image: url('welkii.jpg'); /* Remplacez 'image.jpg' par le chemin de votre image de fond */
		background-size: cover;
		background-position: center;
		display: flex;
		justify-content: center;
		align-items: flex-start;
		min-height: 100vh;
		padding-right: 0px;
		margin: 0px;
		padding: 0px;
	}

	.button-container {
		position: absolute;
		display: block;
		display: flex;
		flex-direction: column;
		align-items: flex-end;

		
}

	.oval-button {
		background-color: #3C3B6E;
		color: white;
		padding: 15px 30px;
		border: none;
		border-radius: 50%;
		cursor: pointer;
		margin: 10px;
		text-decoration: none;
		display: inline-block;
		font-size: 16px;
	}

	.oval-button:hover {
		background-color: #1e1d3c;
	}
	.buttons{
		margin-right: 10px;
		margin-left: 800px;

	}

	
	.overlay {
		position: absolute;
		top: 0;
		left: 0;
		width: 100%;
		height: 100%;
		background-color: rgba(0, 0, 0, 0.5); /* Opacité réglable ici (0.5 = 50%) */
	}
</style>

<title>Welcome</title>

</head>

	<body id='body_welcome' >
	
		<div class="buttons">
			<a href="http://localhost/Projet/inscription.php" class="oval-button">Sign up</a>
			<a href="http://localhost/Projet/connexion.php" class="oval-button">Sign in</a>
		</div>

		</body>
</html>
