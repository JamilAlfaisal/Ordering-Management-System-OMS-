<?php
session_start();
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];

    if (empty($email) || empty($password)) {
        header("location: ../../frontEnd/Backery/Registration/SingUp.php?error=emptyfields");
        exit;
    }

    $conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
    if ($conn->connect_error) {
        die("Database Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT Id, password, role, IsActive FROM BAKERY WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();

        if ($row['password'] == $password && $row['role'] === 'bakery' && $row['IsActive']) {
            $_SESSION['bakery_id'] = $row['Id'];
            header("location: ../../BackEnd/Backery/DashBoardLogic.php");
            exit;

        }else if($row['password'] == $password && $row['role'] === 'Admin'){
            $_SESSION['admin_id'] = $row['Id'];
            header("location: ../../BackEnd/Admin/DashBoardLogic.php");
            exit;
        }else if($row['password'] == $password && $row['role'] === 'bakery' && $row['IsActive'] == 0){
            header("location: ../../frontEnd/Backery/Registration/Login.php?error=inactiveaccount");
            exit;
        } else {
            header("location: ../../frontEnd/Backery/Registration/Login.php?error=wrongpassword");
            exit;
        }

    } else {
        header("location: ../../frontEnd/Backery/Registration/Login.php?error=emailnotfound");
        exit;
    }
}

?>
