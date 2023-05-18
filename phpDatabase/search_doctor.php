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
    $sql = "SELECT * FROM Medecin WHERE Nom_Medecin LIKE ? OR Specialite LIKE ? OR code_postal LIKE ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $name, $specialty, $location);

    $stmt->execute();

    $result = $stmt->get_result();

    $doctors = $result->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
    $conn->close();

    return $doctors;
}

$name = "%" . $_POST['nom'] . "%";
$specialty = "%" . $_POST['specialite'] . "%";
$location = "%" . $_POST['lieu'] . "%";

$doctors = searchDoctors($name, $specialty, $location);

// Save the results to a session variable
session_start();
$_SESSION['search_results'] = $doctors;

// Redirect to the result page
header("Location: ../result.html");
exit();

?>
