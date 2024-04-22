<?php
header('Content-Type: application/json'); // This should be at the very top
ini_set('display_errors', 1);
error_reporting(E_ALL);

require 'bd.php';

$bdd = getBD();
// Assuming you have a database connection set up
// This script simulates fetching data for demonstration purposes

// Retrieve university names and year from query parameters
$university1 = $_GET['university1'] ?? 'University One';
$university2 = $_GET['university2'] ?? 'University Two';
$year = $_GET['year'] ?? date('Y');

$sqlScores = "SELECT u.name AS university_name,
                     scores_teaching, scores_research, scores_citations, 
                     scores_industry_income, scores_international_outlook
              FROM universite u
              JOIN etre e ON e.id_universite = u.id_universite
              JOIN classement c ON e.id_classement = c.id_classement
              WHERE c.annee = :annee AND (u.name = :university_name_1 OR u.name = :university_name_2)
              ORDER BY u.name";

// SQL to fetch line chart data (rank history)
$sqlRanks = "SELECT u.name AS university_name, c.annee, c.rank_order
             FROM universite u
             JOIN etre e ON e.id_universite = u.id_universite
             JOIN classement c ON e.id_classement = c.id_classement
             WHERE (u.name = :university_name_1 OR u.name = :university_name_2)
             AND c.annee BETWEEN :start_year AND :end_year
             ORDER BY u.name, c.annee";

try{

$stmtScores = $bdd->prepare($sqlScores);
$stmtScores->execute(['annee' => $year, 'university_name_1' => $university1, 'university_name_2' => $university2]);
$scoresData = $stmtScores->fetchAll(PDO::FETCH_ASSOC);

$startYear = $year - 5; // Customize this range as needed
$endYear = $year;
$stmtRanks = $bdd->prepare($sqlRanks);
$stmtRanks->execute(['university_name_1' => $university1, 'university_name_2' => $university2, 'start_year' => $startYear, 'end_year' => $endYear]);
$rankData = $stmtRanks->fetchAll(PDO::FETCH_ASSOC);


// Combine all fetched data into one JSON response
echo json_encode(['scores' => $scoresData, 'ranks' => $rankData]);

} catch (PDOException $e) {
    http_response_code(500); // Internal Server Error
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => 'General error: ' . $e->getMessage()]);
}

?>
