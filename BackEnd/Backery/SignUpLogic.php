<?php
    session_start();
    ini_set('display_errors', 1);
    error_reporting(E_ALL);

    require_once __DIR__ . '/../config.php';

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $name = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_SPECIAL_CHARS);
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_SPECIAL_CHARS);
        $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_NUMBER_INT);
        $confirmPassword = filter_input(INPUT_POST, 'ConfirmPassword', FILTER_SANITIZE_NUMBER_INT);
        if (empty($email) || empty($password) || empty($name) || empty($confirmPassword)){
            header("location: ../../frontEnd/Backery/Registration/SingUp.php?error=emptyfields");
            exit;
        }
        if ($password != $confirmPassword){
            header("location: ../../frontEnd/Backery/Registration/SingUp.php?error=passwordcheck");
            exit;
        }
        $conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
        if ($conn->connect_error){
            die("Database Connection failed: " . $conn->connect_error);
        }
        $sql = "INSERT INTO BAKERY (name, email, password) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        // $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $stmt->bind_param("sss", $name, $email, $password);
        $stmt->execute();
        header("location: ../../frontEnd/Backery/Registration/Login.php");
        $stmt->close();
        $conn->close();


    }

?>