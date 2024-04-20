<?php
    ini_set('display_errors', 1);
    error_reporting(E_ALL);
    require_once("bd.php");
    $university1 = $_GET['university1'] ?? 'defaultUniversity1';
    $university2 = $_GET['university2'] ?? 'defaultUniversity2';
    $year = $_GET['year'] ?? date('Y');

    function fetchUniversityRankingData($university1, $university2) {
        $bdd = getBD();
        $sql_rank = "SELECT u.name, c.annee, c.rank_order
                        FROM universite u
                        INNER JOIN etre e ON e.id_universite = u.id_universite
                        INNER JOIN classement c ON e.id_classement = c.id_classement
                        WHERE (u.name = :university_name_1 OR u.name = :university_name_2)
                        ORDER BY c.annee";
        $result_rank = $bdd->prepare($sql_rank);
        $result_rank->bindParam(':university_name', $university_name);
        $result_rank->execute();

        $rankings=array();    
        while($row=$result_rank->fetch(PDO::FETCH_ASSOC)){
            $rankings[] = array(
                "university_name" => $university_name,
                "annee" => $row['annee'],
                "rank_order" => $row['rank_order']
            );
        }
        return $rankings;
    }

    try {

        $rankings = fetchUniversityRankingData($university_name_1, $university_name_2);

    
        // Renvoi des données au format JSON
        header('Content-Type: application/json');
        echo json_encode($mergedRankings);
    } catch (PDOException $e) {
        // Gestion des erreurs de connexion à la base de données
        echo "Erreur de connexion à la base de données : " . $e->getMessage();
    }
?>