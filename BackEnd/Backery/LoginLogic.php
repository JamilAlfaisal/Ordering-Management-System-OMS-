<?php
session_start();
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $password = $_POST['password']; // keep original password

    if (empty($email) || empty($password)) {
        header("location: ../../frontEnd/Backery/Registration/SingUp.php?error=emptyfields");
        exit;
    }

    // DB connection
    $conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
    if ($conn->connect_error) {
        die("Database Connection failed: " . $conn->connect_error);
    }

    // Query
    $sql = "SELECT Id, password FROM BAKERY WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();

        // If passwords are NOT hashed – just compare directly:
        if ($row['password'] == $password) {

            // Successful login
            header("location: ../../frontEnd/Backery/OrderDashboard/OrderDashPage.php?Id=" . urlencode($row['Id']));
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
