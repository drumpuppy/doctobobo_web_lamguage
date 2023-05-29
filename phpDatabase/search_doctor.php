<?php

function searchDoctors($name, $specialty, $location) {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "doctobobo";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT * FROM Medecin WHERE 1=1";
    $types = '';
    $params = [];


    if (!empty($name)) {
        $sql .= " AND Nom_Medecin LIKE ?";
        $types .= 's';
        $params[] = &$name;
    }
    if (!empty($specialty)) {
        $sql .= " AND Specialite LIKE ?";
        $types .= 's';
        $params[] = &$specialty;
    }
    if (!empty($location)) {
        $sql .= " AND code_postal LIKE ?";
        $types .= 's';
        $params[] = &$location;
    }
    $stmt = $conn->prepare($sql);
    if ($types) {
        $stmt->bind_param($types, ...$params);
    }
    $stmt->execute();
    $result = $stmt->get_result();
    $doctors = $result->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
    $conn->close();
    return $doctors;
}

$name = isset($_POST['nom']) ? "%" . $_POST['nom'] . "%" : '';
$specialty = isset($_POST['specialite']) ? "%" . $_POST['specialite'] . "%" : '';
$location = isset($_POST['lieu']) ? "%" . $_POST['lieu'] . "%" : '';

$doctors = searchDoctors($name, $specialty, $location);

session_start();
$_SESSION['search_results'] = $doctors;
header("Location: ../result.html");
exit();
?>