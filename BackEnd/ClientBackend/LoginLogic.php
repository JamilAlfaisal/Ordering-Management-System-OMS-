<?php
session_start(); // Start the session at the very beginning

// Enable error reporting for debugging
ini_set('display_errors', 1);
error_reporting(E_ALL);

// 1. Include Configuration
// This path assumes config.php is one level up (in the BackEnd folder).
require_once __DIR__ . '/../config.php';

// Check if the form was submitted using the POST method
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // 2. Receive and Sanitize Data
    $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_SPECIAL_CHARS);
    $phone = filter_input(INPUT_POST, 'Phone', FILTER_SANITIZE_NUMBER_INT);

    // Basic validation
    if (empty($name) || empty($phone)) {
        header("location: ../../Frontend/customer_login.php?error=emptyfields");
        exit;
    }

    // 3. Connect to Database
    $conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

    // Check connection
    if ($conn->connect_error) {
        error_log("Database Connection failed: " . $conn->connect_error);
        header("location: ../../Frontend/customer_login.php?error=dbconnection");
        exit;
    }
    
    $user_id = 0;
    $db_name = "";

    // --- STEP A: CHECK FOR EXISTING USER ---
    // Note: 'PhoneNumber' is used based on your table creation query. Adjust if needed.
    $sql_check = "SELECT Id, Name FROM USERS WHERE Name = ? AND PhoneNumber = ?";

    if ($stmt_check = $conn->prepare($sql_check)) {
        $stmt_check->bind_param("ss", $name, $phone);
        $stmt_check->execute();
        $stmt_check->store_result();

        if ($stmt_check->num_rows == 1) {
            // **USER FOUND (LOG IN)**
            $stmt_check->bind_result($user_id, $db_name);
            $stmt_check->fetch();
            $stmt_check->close();
            
        } elseif ($stmt_check->num_rows == 0) {
            // **USER NOT FOUND (REGISTER)**
            $stmt_check->close();

            // --- STEP B: INSERT NEW USER ---
            $sql_insert = "INSERT INTO USERS (Name, PhoneNumber) VALUES (?, ?)";
            
            if ($stmt_insert = $conn->prepare($sql_insert)) {
                $stmt_insert->bind_param("ss", $name, $phone);

                if ($stmt_insert->execute()) {
                    // Get the ID of the newly inserted user
                    $user_id = $conn->insert_id;
                    $db_name = $name; // Use the submitted name
                    $stmt_insert->close();
                } else {
                    // Insert failed
                    error_log("User insertion failed: " . $conn->error);
                    $stmt_insert->close();
                    $conn->close();
                    header("location: ../../Frontend/customer_login.php?error=registerfail");
                    exit;
                }
            } else {
                // Insert preparation failed
                error_log("Insert Query failed to prepare: " . $conn->error);
                $conn->close();
                header("location: ../../Frontend/customer_login.php?error=dbprepare");
                exit;
            }

        } else {
            // Database integrity error (multiple users with same credentials)
            $stmt_check->close();
            error_log("Database integrity error: Multiple users found for the same credentials.");
            $conn->close();
            header("location: ../../Frontend/customer_login.php?error=dataissue");
            exit;
        }

    } else {
        // Check preparation failed
        error_log("Check Query failed to prepare: " . $conn->error);
        $conn->close();
        header("location: ../../Frontend/customer_login.php?error=dbprepare");
        exit;
    }
    
    // --- 4. Success: Log in and Redirect (If user_id > 0) ---
    if ($user_id > 0) {
        $_SESSION["loggedin"] = true;
        $_SESSION["user_id"] = $user_id;
        $_SESSION["username"] = $db_name;
        
        // Redirect user to the main ordering page
        // You may need to adjust this path if your index.php is elsewhere
        header("location: ../../Frontend/Client/BakeriesPage/BakeriesPage.php"); 
        
    } else {
        // Fall-through error
        header("location: ../../Frontend/customer_login.php?error=generalerror");
    }

    $conn->close(); // Ensure connection is closed

} else {
    // If someone tries to access this file directly, redirect them
    header("location: ../../Frontend/index.php");
    exit;
}
exit;
?>