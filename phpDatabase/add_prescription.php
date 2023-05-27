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
    $nbrjours= $_POST['NbrJours'];
    $medicament= $_POST['Medicament'];
    


    $sql = "SELECT Prescription_idPrescription FROM Consultation WHERE Patient_idPatient= ? ;";
    $stmt_exist = $conn->prepare($sql);
    $stmt_exist->bind_param("s",$_SESSION['user_id']);
    $stmt_exist->execute();
    $result = $stmt_exist->get_result();
    $stmt_exist->close();




    $idpres = $result;
    
function update_id($id){
    $sql = "UPDATE Consultation SET Prescription_idPrescription= ? ";
    $stmt_up = $conn->prepare($sql);
    $stmt_up->bind_param("s",$idpres);
    if (!$stmt) {
        echo "Error preparing statement: " . $conn->error;
        exit();
    }
    $stmt_up->bind_param("s", $id);
   
    if($stmt_up->execute()){
        echo json_encode(['success' => true]);
    }
    else{
        echo json_encode(['success' => false]);
    }

}
    update_id($idpres);

if($result=null){
    add_Prescription();
}
function add_Prescription(){
$sql = "INSERT INTO Prescription(NbrJours,Medicaments) VALUES (?,?));";

$stmt = $conn->prepare($sql);
$stmt->bind_param("ss",$nbrjours, $medicament);
$result = $stmt->execute();

}

if(!$result){
    echo json_encode(['success' => false, 'message' => 'Execute statement failed: ' . $stmt->error]);
    exit();
}
$stmt->close();
$conn->close();

echo json_encode(['success' => true]);

?>