<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="http://localhost/Projet/style.css" type="text/css" />
    <title>Page de Recherche</title>
    <style>
        .bandeau {
            text-decoration: none;
            color: white;
        }

        #logo {
            margin-left: 130px;
            margin-top: 10px;
            height: 100px;
            width: 100px;
        }

        #logo2 {
            margin-left: 100px;
            margin-top: 5px;
            height: 50px;
            width: 50px;
        }

        #logo3 {
            margin-left: 10px;
            margin-top: 5px;
            height: 50px;
            width: 50px;
        }
    </style>
</head>

<body>
	<!-- bandeau en haut de l'écran -->
		<div class="container">
			<a href= "accueil.php"><img id="logo" src="http://localhost/Projet/images/logo.png" alt="logo" ></a>

			<ul>
			  <li><a class= "bandeau" href="comparer.php">Compare</a></li>
			  <li><a class= "bandeau" href="localiser.php">Map to locate</a></li>
			  <li><a class= "bandeau" href="predire.php" >Prédict</a></li>
			  <li><a class= "bandeau" href="contact.php" >Contact</a></li>
			  <li><a class= "bandeau" href="search.php" >Search</a></li>
			</ul>
			<a href= "favori.php"><img id="logo2" src="http://localhost/Projet/images/favori.png" alt="logo"></a>
			<a href= "monCompte.php"><img id="logo3" src="http://localhost/Projet/images/monCompte.png" alt="logo"></a>
		</div>
    <h1>Rechercher</h1>
    
    <!-- Formulaire de recherche -->
    <form id="searchForm" onsubmit="submitForm(event)">
        <label for="searchInput">Enter a city or university :</label>
        <input type="text" id="searchInput" name="searchInput" placeholder="Type here">
        <button type="submit">Search</button>
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
