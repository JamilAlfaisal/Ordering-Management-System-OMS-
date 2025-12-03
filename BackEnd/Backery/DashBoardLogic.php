<?php
session_start();
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../config.php';


if (!isset($_SESSION['bakery_id'])) {
    header("location: ../../frontend/index.php?error=notloggedin");
    exit;
}

$conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}


$sql_orders = "
    SELECT 
        o.order_date, 
        o.status, 
        o.Id,
        u.Name AS UserId    -- ALIAS u.Name AS UserId to pass the Customer Name to the HTML
    FROM 
        orders AS o
    INNER JOIN 
        users AS u ON o.UserId = u.Id
    WHERE 
        o.BakeryId = ? 
    ORDER BY 
        o.order_date DESC
";

$stmt_orders = $conn->prepare($sql_orders);
$stmt_orders->bind_param("i", $_SESSION['bakery_id']);
$stmt_orders->execute();
$result_orders = $stmt_orders->get_result();
$stmt_orders->close();

$orders = [];

if ($result_orders->num_rows > 0) {
    while ($row = $result_orders->fetch_assoc()) {
        $orders[] = $row;
    }
}

$sql_pastries = "
SELECT
    Item, 
    Number,
    OrderId
FROM
    pastries
WHERE
    OrderId = ?;
";

$stmt_pastries = $conn->prepare($sql_pastries);

$pastries = [];

for ($i = 0; $i < count($orders); $i++) {
    $stmt_pastries->bind_param("i", $orders[$i]['Id']);
    $stmt_pastries->execute();
    $result_pastries = $stmt_pastries->get_result();
    
    $pastries[$orders[$i]['Id']] = [];
    
    if ($result_pastries->num_rows > 0) {
        while ($row = $result_pastries->fetch_assoc()) {
            $pastries[$orders[$i]['Id']][] = $row;
        }
    }
}

$stmt_pastries->close();

require_once "../../frontEnd/Backery/OrderDashboard/OrderDashPage.php";
$conn->close();
?>