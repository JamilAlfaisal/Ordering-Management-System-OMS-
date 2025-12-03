<?php 
session_start();
ini_set('display_errors', 1);
error_reporting(E_ALL);
require_once __DIR__ . '/../config.php';
if (!isset($_SESSION['admin_id'])) {
    header("location: ../../frontend/index.php?error=notloggedin");
    exit;
}
$conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM BAKERY WHERE role = 'bakery'";
$result = $conn->query($sql);

$sqlUsers = "SELECT * FROM users";
$resultUsers = $conn->query($sqlUsers);

require_once "../../frontEnd/Admin/DashBoardPage.php";
$conn->close();

?>