<?php 
    ini_set('display_errors', 1);
    error_reporting(E_ALL);

    require_once __DIR__ . '/../config.php';


    $conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

    if ($conn->connect_error){
        die("Database Connection failed: " . $conn->connect_error);
        // Better practice: log the error and display a generic message
        // error_log("Database Connection failed: " . $conn->connect_error);
        $bakeries = [1,2,3]; // Initialize an empty array to prevent view errors
        $error_message = "Could not connect to the database at this time.";
    }

    $sql = "SELECT Id, name FROM BAKERY ORDER BY name ASC";
    // is 2D array of available bakeries 
    $result = $conn->query($sql);

    $bakeries = [];
    $error_message = '';

    if ($result && $result->num_rows > 0){
        $bakeries = $result->fetch_all(MYSQLI_ASSOC);
    } else {
        // $error_message = "No bakeries found.";
        die("No bakeries found.");
    }

    // print_r($bakeries[0]);

    // Pass the prepared $bakeries array and $error_message to the view template
    require_once '../../frontEnd/Client/BakeriesPage/BakeriesPage.php';
?>