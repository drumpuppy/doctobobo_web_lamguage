<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

function checkCredentials($email, $password, $userType) {

    $servername = "localhost";
    $username = "root";
    $db_password = "";
    $dbname = "doctobobo";


    // Create connection
    $conn = new mysqli($servername, $username, $db_password, $dbname);


    // Check connection
    if ($conn->connect_error) {
        error_log("Connection failed: " . $conn->connect_error);
        die("Connection failed: " . $conn->connect_error);
    }

    // SQL query based on user type
    if ($userType === "docteur") {
        $sql = "SELECT idMedecin FROM Medecin WHERE email = ? AND password = ?";
    } elseif ($userType === "patient") {
        $sql = "SELECT idPatient FROM Patient WHERE email = ? AND password = ?";
        error_log("Invalid user type: " . $sql);
    } else {
        error_log("Invalid user type: " . $userType);
        return false;
    }

    // Prepare and bind the SQL query
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $email, $password);

    // Execute the query
    if ($stmt->execute()) {
        error_log("Query executed successfully");
    } else {
        error_log("Query execution failed: " . $stmt->error);
    }

    // Get the result
    $result = $stmt->get_result();
    $userId = $result->fetch_assoc();

    if ($userId) {
        error_log("User found: " . json_encode($userId));
    } else {
        error_log("No user found with the given credentials");
    }

    // Close the connection
    $stmt->close();
    $conn->close();

    return $userId;
}



$email = $_POST['email'];
$password = $_POST['pwd'];
$userType = $_POST['titre'];

$userId = checkCredentials($email, $password, $userType);
header('Content-Type: application/json');

if ($userId) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false]);
}
?>
