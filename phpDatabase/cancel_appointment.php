<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Not logged in']);
    exit();
}

if (!isset($_POST['appointment_id'])) {
    echo json_encode(['success' => false, 'message' => 'No appointment ID provided']);
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

$userId = $_SESSION['user_id'];
$userType = $_SESSION['user_type'];
$appointmentId = $_POST['appointment_id'];

if ($userType === 'docteur') {
    $sql = "DELETE FROM Consultation WHERE idConsultation = ? AND Medecin_idMedecin = ?";
} else {
    $sql = "DELETE FROM Consultation WHERE idConsultation = ? AND Patient_idPatient = ?";
}

$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $appointmentId, $userId);
$success = $stmt->execute();

if ($success) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to cancel appointment']);
}

$stmt->close();
$conn->close();
?>
