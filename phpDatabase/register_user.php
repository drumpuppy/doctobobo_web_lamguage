<?php

function emailExists($email, $userType, $conn) {
    if ($userType === 'docteur') {
        $table = 'Medecin';
    } else {
        $table = 'Patient';
    }

    $sql = "SELECT * FROM $table WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();

    return $result->num_rows > 0;
}

function isValidDate($date) {
    $dateArray = explode('/', $date);

    if (count($dateArray) !== 3) {
        return false;
    }

    return checkdate($dateArray[1], $dateArray[0], $dateArray[2]);
}

function convertDate($date) {
    $dateArray = explode('/', $date);
    return $dateArray[2] . '-' . $dateArray[1] . '-' . $dateArray[0];
}



function createUser($userType, $firstName, $lastName, $birthdate, $email, $password, $speciality = null) {
    $servername = "localhost";
    $username = "root";
    $db_password = "";
    $dbname = "doctobobo";

    $conn = new mysqli($servername, $username, $db_password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    if (emailExists($email, $userType, $conn)) {
        header("Location: ../inscription.html?error=email_exists");
        exit();
    }
    
    if (!isValidDate($birthdate)) {
        header("Location: ../inscription.html?error=invalid_date");
        exit();
    }
    
    $birthdate = convertDate($birthdate);
    

    if ($userType === "docteur") {
        $sql = "INSERT INTO Medecin (Nom_Medecin, Prenom_Medecin, DateNaissance, Specialite, email, password) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssss", $lastName, $firstName, $birthdate, $speciality, $email, $password);
    } else {
        $sql = "INSERT INTO Patient (Nom_Patient, Prenom_Patient, DateNaissance, email, password) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssss", $lastName, $firstName, $birthdate, $email, $password);
    }

    $result = $stmt->execute();
    $stmt->close();
    $conn->close();

    return $result;
}

$userType = $_POST['titre'];
$firstName = $_POST['prenom'];
$lastName = $_POST['nom'];
$birthdate = $_POST['age'];
$email = $_POST['email'];
$password = md5($_POST['pwd']);
$speciality = $_POST['specialite'];


$result = createUser($userType, $firstName, $lastName, $birthdate, $email, $password, $speciality);

if ($result) {
    header("Location: ../my_space.html");
} else {
    header("Location: ../inscription.html?error=1");
}
?>
