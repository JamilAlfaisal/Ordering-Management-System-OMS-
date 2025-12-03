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
$currentBakeyyStatus = $_GET['IsActive'] ? 0 : 1;
print_r($_GET['IsActive']);
print_r($_GET['bakery_id']);

$sql = "UPDATE `bakery` SET `IsActive` = $currentBakeyyStatus WHERE `Id` = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $_GET['bakery_id']);
$stmt->execute();
header("location: ../../BackEnd/Admin/DashBoardLogic.php");
$conn->close();

?>