<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "doctobobo";
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$doctor_id = $_POST['doctorId'];
$date = $_POST['date'];

$sql = "SELECT DateHeure FROM Consultation WHERE Medecin_idMedecin = ? AND DATE(DateHeure) = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("is", $doctor_id, $date);
$stmt->execute();

$result = $stmt->get_result();
$bookedSlots = array();
while($row = $result->fetch_assoc()) {
    $date = new DateTime($row['DateHeure']);
    $bookedSlots[] = $date->format('H:i');
}


$allSlots = array();
$startHour = 8; // 8 AM
$endHour = 21; // 9 PM

for ($hour = $startHour; $hour < $endHour; $hour++) {
    for ($minute = 0; $minute < 60; $minute += 15) {
        $time = str_pad($hour, 2, '0', STR_PAD_LEFT) . ":" . str_pad($minute, 2, '0', STR_PAD_LEFT);
        $allSlots[] = $time;
    }
}

$availableSlots = array_values(array_diff($allSlots, $bookedSlots));
echo json_encode($availableSlots);
$stmt->close();
$conn->close();
?>
