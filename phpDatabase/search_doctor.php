<?php

function searchDoctors($name, $specialty, $location) {
    // Database connection
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "doctobobo";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // SQL query
    $sql = "SELECT * FROM Medecin WHERE Nom_Medecin LIKE ? AND Specialite LIKE ? AND code_postal LIKE ?";

    // Prepare and bind the SQL query
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $name, $specialty, $location);

    // Execute the query
    $stmt->execute();

    // Get the result
    $result = $stmt->get_result();

    // Fetch all the doctors
    $doctors = $result->fetch_all(MYSQLI_ASSOC);

    // Close the connection
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
