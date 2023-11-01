<?php
function getBD(){
	$bdd = new PDO('mysql:host=localhost;dbname=projet_universite;charset=utf8','root', '');
	return $bdd;
}
?>