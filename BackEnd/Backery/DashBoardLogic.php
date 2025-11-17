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

// Check connection
if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

// ==========================
// 2. FETCH ORDERS AND CUSTOMER NAME (SECURELY)
// ==========================

// This query correctly fetches the order details and the customer's name (aliased as UserId).
// (ORDER joins USER using UserId)
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
// 'i' means the parameter is an integer (for bakery_id)
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


// ==========================
// 3. FETCH PASTRIES (ITEMS) FOR EACH ORDER
// ==========================

// This query is correctly simplified to only query the 'pastries' table
// based on OrderId, as confirmed by your ER diagram (PASTRIES table lacks UserId).
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

// Loop through the fetched orders to get the items for each order
for ($i = 0; $i < count($orders); $i++) {
    // Reusing the prepared statement is efficient
    $stmt_pastries->bind_param("i", $orders[$i]['Id']);
    $stmt_pastries->execute();
    $result_pastries = $stmt_pastries->get_result();
    
    // Store pastries data keyed by the Order ID
    $pastries[$orders[$i]['Id']] = [];
    
    if ($result_pastries->num_rows > 0) {
        while ($row = $result_pastries->fetch_assoc()) {
            $pastries[$orders[$i]['Id']][] = $row;
        }
    }
}

$stmt_pastries->close();

// Close connection
require_once "../../frontEnd/Backery/OrderDashboard/OrderDashPage.php";
$conn->close();
?>