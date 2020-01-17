<?php
session_start();

$results = array();
if (isset($_SESSION['results'])) { $results = $_SESSION['results']; }

ob_clean();
header("Content-type: text/csv");

$fp = fopen('php://output', 'w');

foreach ($results as $row) {
    fputcsv($fp, $row);
}

fclose($fp);
exit(0);

?>
