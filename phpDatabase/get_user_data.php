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

$user_id = $_SESSION['user_id'];
$user_type = $_SESSION['user_type'];

if ($user_type === 'docteur') {
    $sql = "SELECT * FROM Medecin WHERE idMedecin = ?";
} else {
    $sql = "SELECT * FROM Patient WHERE idPatient = ?";
}

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();

$result = $stmt->get_result();
$user_data = $result->fetch_assoc();

$stmt->close();
$conn->close();

echo json_encode(['success' => true, 'data' => $user_data, 'user_type' => $user_type]);
?>
