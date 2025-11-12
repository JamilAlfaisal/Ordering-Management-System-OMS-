<?php 
    session_start();
    ini_set('display_errors', 1);
    error_reporting(E_ALL);
    

    require_once __DIR__ . '/../config.php';

    if (!isset($_SESSION['user_id'])) {
        header("location: ../../frontend/index.php?error=notloggedin");
        exit;
    }

    if (isset($_GET['bakery_id']) && filter_var($_GET['bakery_id'], FILTER_VALIDATE_INT)) {
        $bakeryId = (int)$_GET['bakery_id']; 
    } else {
        die("Error: Invalid or missing Bakery ID in URL."); 
    }

    $userId = $_SESSION['user_id'];
    
    $conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
    if ($conn->connect_error){
        die("Database Connection failed: " . $conn->connect_error);
    }
    $sql = "SELECT Id, status FROM ORDERS WHERE UserId = ? AND BakeryId = ? ORDER BY order_date DESC";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $userId, $bakeryId);
    $stmt->execute();
    $result = $stmt->get_result();
    $orders = [];
    while ($row = $result->fetch_assoc()) {
        $orders[] = $row;
    }
    // print_r($orders);
    $stmt->close();

    $sql_pastries = "SELECT item, Number FROM PASTRIES WHERE OrderId = ?";
    $stmt_pastries = $conn->prepare($sql_pastries);
    $pastriesByOrder = [];
    foreach ($orders as $order) {
        $stmt_pastries->bind_param("i", $order['Id']);
        $stmt_pastries->execute();
        $result_pastries = $stmt_pastries->get_result();
        $pastries = "";
        while ($row = $result_pastries->fetch_assoc()) {
            $pastries .= $row["Number"]."×".$row["item"].", ";
        }
        $pastriesByOrder[$order['Id']] = $pastries;
    }
    $stmt_pastries->close();

    // print_r($pastriesByOrder);
    require_once '../../frontEnd/Client/OrderStatuesPage/OrderStatusPage.php';
    $conn->close();
?>