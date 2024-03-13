<?php
require("bd.php");

if($_SERVER["REQUEST_METHOD"] == "POST") {
    $university1 = $_POST["university1"];
    $university2 = $_POST["university2"];

    $bdd = getBD();    

    try{
        $bdd= getBD();
        $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $bdd->prepare("SELECT * FROM universite WHERE name= :name1 OR name= :name2");
        $stmt->execute(array(':name1'=>$university1, ':name2'=>$university2));
        $universities=$stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach($universities as $university){
            echo $university['name'];
        }
    }
    catch(PDOException $e){
        echo "Erreur: " . $e->getMessage();
    }
    finally{
        header("Location: comparison_universities.php");
    }
}
else{
    header("Location: comparison.php");
    exit;
}

?>