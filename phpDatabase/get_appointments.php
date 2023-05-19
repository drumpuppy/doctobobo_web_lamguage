<?php
session_start();

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

$userId = $_SESSION['user_id'];
$userType = $_SESSION['user_type'];

if ($userType === 'docteur') {
    $sql = "SELECT * FROM Consultation WHERE Medecin_idMedecin = ? AND DateHeure > NOW() ORDER BY DateHeure ASC";
} else {
    $sql = "SELECT * FROM Consultation WHERE Patient_idPatient = ? AND DateHeure > NOW() ORDER BY DateHeure ASC";
}

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userId);
$stmt->execute();

$result = $stmt->get_result();
$appointments = $result->fetch_all(MYSQLI_ASSOC);

$stmt->close();
$conn->close();

echo json_encode($appointments);
?>
