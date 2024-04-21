<?php
session_start();
require("bd.php");
$conn = getBD();

if (!isset($_SESSION['client'])) {
    echo "<script>alert('Please log in to view your favorites colleges.'); window.location.href='connexion.php';</script>";
    exit;

}

$client_id = $_SESSION['client']['id'];
$sql = "SELECT name FROM favoris WHERE id_client = ?";
$stmt = $conn->prepare($sql);
$stmt->execute([$client_id]);
$favorites = $stmt->fetchAll(PDO::FETCH_ASSOC);

$conn = null; // Properly closing the PDO connection
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Favorites - University</title>
    <link rel="stylesheet" href="style.css" type="text/css"/>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .bandeau{
            text-decoration: none;
			color:white;
			
		}

		#logo{
			margin-left:130px;
			margin-top:10px;
			height:100px;
			width:100px;
		}

		#logo2{
			margin-left:100px;
			margin-top:5px;
			height:50px;
			width:50px;
		}

		#logo3{
			margin-left:10px;
			margin-top:5px;
			height:50px;
			width:50px;
		}
		.container {
			height:90px;
			background-color: #3C3B6E;
			color: white;
			padding-top: 10px;
			padding-bottom: 10px;
			display: flex;
			justify-content: center;
			align-items: center;
			width: 100%;
			margin: 0;
			max-width: none;
		}

		.container > ul {
			position: relative;
			margin-top:30px;
			transform: translateY(-50%);	
			text-align: center;
			background-color:#3C3B6E;
			width:800px;
		}
		.container > ul > li{
			list-style-type: none;
			display: inline;
			margin-right: 50px;
			
		}
		li:hover{
			font-size: 20px;
		}

		.container ul li a {
			color: white;
			text-decoration: none;
		}
		h1 {
			text-align: center;
			color: #333;
		}
		.favorites-list {
			margin: 20px auto;
			padding: 20px;
			width: 90%;
			background-color: #fff;
			box-shadow: 0 2px 5px rgba(0,0,0,0.1);
			border-radius: 8px;
		
		}
		.favorites-list ul {
			list-style: none;
			padding: 0;
		}
		.favorites-list li {
			padding: 10px;
			border-bottom: 1px solid #eee;
		}
		.favorites-list li:last-child {
			border-bottom: none;
		}
    </style>
</head>
<body>
<div class="container">

		<a href= "accueil.php"><img id="logo" src="images/logo.png" alt="logo" ></a>
	
		<ul>
			<li><a class= "bandeau" href="compare.php">Compare</a></li>
			<li><a class= "bandeau" href="localisation.php">Map</a></li>
			<li><a class= "bandeau" href="predire.php" >Predict</a></li>
			<li><a class= "bandeau" href="contact.php" >Contact</a></li>
			<li><a class= "bandeau" href="search_university.html" >Search</a></li>
		</ul>
		<a href= "favoris.php"><img id="logo2" src="images/favori.png" alt="logo"></a>
		<a href= "monCompte.php"><img id="logo3" src="images/monCompte.png" alt="logo"></a>
	</div>

<?php if ($favorites): ?>
    <div class="favorites-list">
        <h1>My Favorite Universities</h1>
        <ul>
            <?php foreach ($favorites as $fav): ?>
                <li><?= htmlspecialchars($fav['name']); ?></li>
            <?php endforeach; ?>
        </ul>
    </div>

<?php else: ?>
    <div class="favorites-list">
        <h1>You have no favorite colleges.</h1>
    </div>
<?php endif; ?>
<footer id="footer">
    Copyright © 2023 UniDiscover
</footer>
</body>
</html>
