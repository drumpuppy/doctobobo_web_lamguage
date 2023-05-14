<?php
    session_start();

    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    if (!isset($_SESSION['user_id'])) {
        echo json_encode(['success' => false]);
        exit();
    }

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "doctobobo";
    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $user_id = $_SESSION['user_id'];
    $user_type = $_SESSION['user_type'];
    if ($user_type === "patient") {
        $sql = "UPDATE patient SET Nom_Patient=?, Prenom_Patient=?, DateNaissance=?, adresse=?, code_postal=? WHERE idPatient=?";
    } else if ($user_type === "docteur") {
        $sql = "UPDATE medecin SET Nom_Medecin=?, Prenom_Medecin=?, DateNaissance=?, adresse=?, code_postal=?, Specialite=? WHERE idMedecin=?";
    } else {
        echo json_encode(['success' => false]);
        exit();
    }

    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        echo "Error preparing statement: " . $conn->error;
        exit();
    }
    if ($user_type === "patient") {
        $stmt->bind_param("sssssi", $_POST['last_name'], $_POST['first_name'], $_POST['birthdate'], $_POST['address'], $_POST['postal_code'], $user_id);
    } else {
        $stmt->bind_param("ssssssi", $_POST['last_name'], $_POST['first_name'], $_POST['birthdate'], $_POST['address'], $_POST['postal_code'], $_POST['specialty'], $user_id);
    }

    header('Content-Type: application/json');

    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false]);
    }

    $stmt->close();
    $conn->close();
?>