<?php
function getBD(){
	$bdd = new PDO('mysql:host=localhost;dbname=projet_universite;charset=utf8','root', '');
	return $bdd;
}


function getBdd(){
	$host = "localhost";  // ou l'IP du serveur
	$dbname = "projet_universite";
	$username = "root";
	$password = "";
	$bdd = new mysqli($host, $username, $password, $dbname);
	return $bdd;
}
?>