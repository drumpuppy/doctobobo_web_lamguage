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

    if ($user_type !== "docteur") {
        echo json_encode(['success' => false]);
        exit();
    }

    $medicaments = filter_var($_POST['medicaments'], FILTER_SANITIZE_STRING);
    $nbrjours = filter_var($_POST['nbrjours'], FILTER_SANITIZE_NUMBER_INT);
    $appointmentId = filter_var($_POST['appointmentId'], FILTER_SANITIZE_NUMBER_INT);

    $sql_get_prescription = "SELECT Prescription_idPrescription FROM Consultation WHERE idConsultation = ?";
    $stmt_get_prescription = $conn->prepare($sql_get_prescription);
    $stmt_get_prescription->bind_param("i", $appointmentId);
    $stmt_get_prescription->execute();
    $result = $stmt_get_prescription->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $prescription_id = $row['Prescription_idPrescription'];

        $sql_update_prescription = "UPDATE Prescription SET Medicaments=?, NbrJours=? WHERE idPrescription = ?";
        $stmt_update_prescription = $conn->prepare($sql_update_prescription);
        $stmt_update_prescription->bind_param("sii", $medicaments, $nbrjours, $prescription_id);

        header('Content-Type: application/json');

        if ($stmt_update_prescription->execute()) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'error' => 'Failed to execute statement.']);
        }
    } else {
        echo json_encode(['success' => false, 'error' => 'No linked prescription found.']);
    }

    $stmt_get_prescription->close();
    $stmt_update_prescription->close();
    $conn->close();
?>
