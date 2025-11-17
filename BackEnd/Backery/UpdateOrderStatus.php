<?php
// frontEnd/Backery/OrderDashboard/UpdateOrderStatus.php
// This page allows bakery staff to update the status of orders.
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
    print_r($_GET['Order_Id']);
    if (isset($_GET['Order_Id'])) {
        $orderId = intval($_GET['Order_Id']);
        // Update the order status to 'Completed'
        $newStatus = 'Completed';
        $stmt = $conn->prepare("UPDATE orders SET status = ? WHERE Id = ? AND BakeryId = ?");
        $stmt->bind_param("sii", $newStatus, $orderId, $_SESSION['bakery_id']);
        if ($stmt->execute()) {
            header("location: ../../BackEnd/Backery/DashBoardLogic.php?success=orderupdated");
            exit;
        } else {
            echo "Error updating order status: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "No Order_Id provided.";
    }
?>