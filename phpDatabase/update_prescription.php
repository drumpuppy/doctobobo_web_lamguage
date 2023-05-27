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
    $id_prescription = $_POST['id_Prescription'];
    $nbrjours= $_POST['NbrJours'];
    $medicament= $_POST['Medicament'];
    

    $sql = "UPDATE Prescription SET NbrJours = ?, Medicaments=? WHERE idPrescription= ?;";
    
    
$stmt = $conn->prepare($sql);

if (!$stmt) {
    echo "Error preparing statement: " . $conn->error;
    exit();
}
$stmt->bind_param("sss", $_POST['NbrJours'], $_POST['Medicament'], $_POST['id_Prescription']);
if($stmt->execute()){
    echo json_encode(['success' => true]);
}
else{
    echo json_encode(['success' => false]);
}

$stmt->close();
$conn->close();


?>