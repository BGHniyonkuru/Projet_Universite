<?php
require_once("bd.php");
// Récupération des scores pour une année spécifique et pour les universités spécifiées
$annee = $_GET['annee'] ?? '';
$searchQuery = isset($_GET['search']) ? $_GET['search'] : '';
$university_name_1 = $_GET['university_name_1'] ?? '';
$university_name_2 = $_GET['university_name_2'] ?? '';
function fetchUniversityData($annee, $university_name_1, $university_name_2) {
    $bdd = getBD();
    $sql_scores = "SELECT scores_teaching, scores_research, scores_citations, 
                scores_industry_income, scores_international_outlook, 
                stats_number_students, stats_pc_intl_students, 
                stats_student_staff_ratio 
                FROM universite u
                JOIN etre e ON e.id_universite = u.id_universite
                JOIN classement c ON e.id_classement = c.id_classement
                WHERE c.annee = :annee AND (u.name = :university_name_1 OR u.name = :university_name_2)";

    $result_scores = $bdd->prepare($sql_scores);
    $result_scores->bindParam(':annee', $annee, PDO::PARAM_INT);
    $result_scores->bindParam(':university_name_1', $university_name_1);
    $result_scores->bindParam(':university_name_2', $university_name_2);
    $result_scores->execute();

    $scores = $result_scores->fetchAll(PDO::FETCH_ASSOC);
    return $scores;
}

try {

    $scores = fetchUniversityData($annee, $university_name_1, $university_name_2);

    $bdd = null;

    // Renvoi des données au format JSON
    header('Content-Type: application/json');
    echo json_encode($scores);
} catch (PDOException $e) {
    // Gestion des erreurs de connexion à la base de données
    echo "Erreur de connexion à la base de données : " . $e->getMessage();
}
?>
