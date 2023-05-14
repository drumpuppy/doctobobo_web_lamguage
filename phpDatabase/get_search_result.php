<?php
session_start();
header('Content-Type: application/json');

if (isset($_SESSION['search_results'])) {
    echo json_encode($_SESSION['search_results']);
} else {
    echo json_encode([]);
}
?>
