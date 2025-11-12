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

    $conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

    if ($conn->connect_error){
        die("Database Connection failed: " . $conn->connect_error);
        // Better practice: log the error and display a generic message
        // error_log("Database Connection failed: " . $conn->connect_error);
        $bakeries = [1,2,3]; // Initialize an empty array to prevent view errors
        $error_message = "Could not connect to the database at this time.";
    }
    $sql = "SELECT name FROM BAKERY WHERE Id = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $_GET['bakery_id']);
    $stmt->execute();
    $stmt->bind_result($bakery_name);

    if(!$stmt->fetch()){
        die("Error: Bakery Not Found.");
    }
    $stmt->close(); 
    // if ($stmt->fetch()) {
    //     echo "<h1>" . htmlspecialchars($bakery_name) . "</h1>";
    // } else {
    //     echo "<h1>Bakery Not Found</h1>";
    // }

    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        $sql_order = "INSERT INTO ORDERS (UserId, BakeryId, order_date) VALUES (?, ?, NOW())";
        $stmt_order = $conn->prepare($sql_order);
        $stmt_order->bind_param("ii", $_SESSION['user_id'], $bakeryId);
        $stmt_order->execute();
        $orderId = $stmt_order->insert_id;
        $stmt_order->close();

        $item_names = $_POST['item_name'];
        $item_quantities = $_POST['item_qty'];

        $sql_item = "INSERT INTO PASTRIES (OrderId, item, Number) VALUES (?, ?, ?)";
        $stmt_item = $conn->prepare($sql_item);
        for ($i = 0; $i < count($item_names); $i++) {
            $item_name = $item_names[$i];
            $item_qty = (int)$item_quantities[$i];
            $stmt_item->bind_param("isi", $orderId, $item_name, $item_qty);
            $stmt_item->execute();
        }
        $stmt_item->close();
        header("Location: /OMS/BackEnd/ClientBackend/OrderStatusLogic.php?bakery_id=" . urlencode($bakeryId));
    }

    $conn->close();

    require_once '../../frontEnd/Client/OrderPage/OrderPage.php';

?>