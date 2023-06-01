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
    $sql = "SELECT c.*, p.Prenom_Patient, p.Nom_Patient, pr.Medicaments, pr.NbrJours FROM Consultation c JOIN Patient p ON c.Patient_idPatient = p.idPatient JOIN Prescription pr ON c.Prescription_idPrescription = pr.idPrescription WHERE c.Medecin_idMedecin = ? AND c.DateHeure > NOW() ORDER BY c.DateHeure ASC";
} else {
    $sql = "SELECT c.*, m.Prenom_Medecin, m.Nom_Medecin, m.adresse, pr.Medicaments, pr.NbrJours FROM Consultation c JOIN Medecin m ON c.Medecin_idMedecin = m.idMedecin JOIN Prescription pr ON c.Prescription_idPrescription = pr.idPrescription WHERE c.Patient_idPatient = ? AND c.DateHeure > NOW() ORDER BY c.DateHeure ASC";
}


$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userId);
$stmt->execute();

$result = $stmt->get_result();
$appointments = $result->fetch_all(MYSQLI_ASSOC);

$response = array(
    'userType' => $userType,
    'appointments' => $appointments,
);

$stmt->close();
$conn->close();

echo json_encode($response);
?>
