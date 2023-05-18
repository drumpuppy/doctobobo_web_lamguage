<?php
session_start();
var_dump($_SESSION);


header('Content-Type: application/json');

if (!isset($_SESSION['user_id'], $_SESSION['user_type'])) {
    echo json_encode(['success' => false, 'message' => 'User not logged in']);
    exit();
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "doctobobo";
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    echo json_encode(['success' => false, 'message' => 'DB connection error']);
    exit();
}

$user_id = $_SESSION['user_id'];
$user_type = $_SESSION['user_type'];
$doctor_id = $_POST['doctorId'];
$date = $_POST['date'];
$time = $_POST['time'];
$datetime = $date . ' ' . $time;

if ($user_type !== 'patient') {
    echo json_encode(['success' => false, 'message' => 'Only patients can book appointments']);
    exit();
}

$sql = "INSERT INTO Consultation (DateHeure, Patient_idPatient, Medecin_idMedecin, motif, description) VALUES (?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);

if(!$stmt){
    echo json_encode(['success' => false, 'message' => 'Prepare statement failed']);
    exit();
}

$motif = ""; // TODO
$description = ""; // TODO
$stmt->bind_param("siiss", $datetime, $user_id, $doctor_id, $motif, $description);
echo $stmt->affected_rows;
$result = $stmt->execute();
echo $stmt->affected_rows;

if(!$result){
    echo json_encode(['success' => false, 'message' => 'Execute statement failed: ' . $stmt->error]);
    exit();
}

$stmt->close();
$conn->close();

echo json_encode(['success' => true]);
?>
