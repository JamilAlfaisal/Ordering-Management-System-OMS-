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

$userId = $_GET['user_id'] ?? null;

if ($userId === null) {
    die("Error: User ID is required.");
}

$userId = intval($userId);


// deleting pastires of a user
$sqlOrderId = "SELECT Id FROM orders WHERE UserId = ?";
$stmt = $conn->prepare($sqlOrderId);

if ($stmt === false) {
    die("Error preparing statement: " . $conn->error);
}
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $deletePastires = "DELETE FROM pastries WHERE OrderId= ?";
        $stmtPast = $conn->prepare($deletePastires);
        if ($stmtPast === false) {
            die("Error preparing statement: " . $conn->error);
        }
        $stmtPast->bind_param("i", $row['Id']);
        echo "<br></br>";
        if ($stmtPast->execute()) {
            echo "Deleted pastries for Order ID: " . $row['Id'] . "<br>";
        } else {
            echo "Error deleting pastries: " . $stmtPast->error . "<br>";
        }
    }
}

// deleting orders of a user 
$sqlDeleteOrders= "DELETE FROM orders WHERE UserId= ?";
$stmtDeleteOrder = $conn->prepare($sqlDeleteOrders);

if ($stmtDeleteOrder === false) {
    die("Error preparing statement: " . $conn->error);
}

$stmtDeleteOrder->bind_param("i", $userId);

if ($stmtDeleteOrder->execute()) {
    echo "<br>Deleted Orders of user Id: " . $userId . "<br>";
} else {
    echo "Error deleting order: " . $stmtDeleteOrder->error . "<br>";
}


// deleting User

$sqlDeleteUser= "DELETE FROM users WHERE Id= ?";
$stmtDeleteUser = $conn->prepare($sqlDeleteUser);

if ($stmtDeleteUser === false) {
    die("Error preparing statement: " . $conn->error);
}

$stmtDeleteUser->bind_param("i", $userId);

if ($stmtDeleteUser->execute()) {
    echo "<br>Deleted user Id: " . $userId . "<br>";
} else {
    echo "Error deleting user: " . $stmtDeleteOrder->error . "<br>";
}

echo "wait will return to admin page in 3 seconds ......";

echo 
"
    <script>
        const delayInMilliseconds = 3000;
        const destinationURL = '../../BackEnd/Admin/DashBoardLogic.php';
        setTimeout(function() {
            window.location.href = destinationURL;
        }, delayInMilliseconds);
    </script>
";

?>