<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="http://localhost/Projet/style.css" type="text/css" />
    <title>Page de Recherche</title>
</head>

<body>
	<!-- bandeau en haut de l'écran -->
		<div class="container">
			<a href= "accueil.php"><img id="logo" src="http://localhost/Projet/images/logo.png" alt="logo" ></a>

			<ul>
			  <li><a class= "bandeau" href="comparer.php">Comparer</a></li>
			  <li><a class= "bandeau" href="localiser.php">Localiser</a></li>
			  <li><a class= "bandeau" href="predire.php" >Prédire</a></li>
			  <li><a class= "bandeau" href="contact.php" >Contact</a></li>
			  <li><a class= "bandeau" href="search.php" >Rechercher</a></li>
			</ul>
			<a href= "compte.php"><img id="logo2" src="http://localhost/Projet/images/favori.png" alt="logo"></a>
			<a href= "favori.php"><img id="logo3" src="http://localhost/Projet/images/monCompte.png" alt="logo"></a>
		</div>
    <h1>Rechercher</h1>
    
    <!-- Formulaire de recherche -->
    <form id="searchForm" onsubmit="submitForm(event)">
        <label for="searchInput">Entrez le nom de la ville ou de l'université :</label>
        <input type="text" id="searchInput" name="searchInput" placeholder="Tapez ici">
        <button type="submit">Rechercher</button>
    </form>

    <!-- Conteneur pour afficher les résultats -->
    <div id="searchResults"></div>

    <script>
        function submitForm(event) {
            event.preventDefault(); // Empêche le formulaire de se soumettre normalement

            var searchInput = document.getElementById('searchInput').value;
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    document.getElementById('searchResults').innerHTML = xhr.responseText;
                }
            };
            xhr.open('GET', 'rechercher.php?q=' + searchInput, true);
            xhr.send();
        }
    </script>
</body>
</html>
