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

$datetime_object = new DateTime($datetime);

if ($datetime_object <= new DateTime()) {
    echo json_encode(['success' => false, 'message' => 'Appointment must be scheduled for a future time']);
    exit();
}

$hour = $datetime_object->format('H');
$minute = $datetime_object->format('i');

if ($hour < 8 || $hour > 19 || $minute % 15 !== 0) {
    echo json_encode(['success' => false, 'message' => 'Appointment must be between 8:00 and 19:00 and on the quarter-hour']);
    exit();
}

if ($user_type !== 'patient') {
    echo json_encode(['success' => false, 'message' => 'Only patients can book appointments']);
    exit();
}

$sql_check = "SELECT * FROM Consultation WHERE Medecin_idMedecin = ? AND DateHeure = ?";
$stmt_check = $conn->prepare($sql_check);
$stmt_check->bind_param("is", $doctor_id, $datetime);
$stmt_check->execute();

$result_check = $stmt_check->get_result();
if ($result_check->num_rows > 0) {
    echo json_encode(['success' => false, 'message' => 'Doctor already has an appointment at this time']);
    exit();
}

$stmt_check->close();

$sql = "INSERT INTO Consultation (DateHeure, Patient_idPatient, Medecin_idMedecin, motif, description) VALUES (?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);

if(!$stmt){
    echo json_encode(['success' => false, 'message' => 'Prepare statement failed']);
    exit();
}

$motif = "";
$description = "";
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
