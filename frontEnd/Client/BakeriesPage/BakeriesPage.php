<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="BakeriesPage.css">
    <title>Available Bakeries</title>
</head>
<body>
    <?php
        for ($i = 1; $i <= 5; $i++) {
            echo "<div class='bakery-card'>
                    <h2>Bakery $i</h2>
                    <p>Freshly baked goods every day!</p>
                  </div>";
        }
    ?>
</body>
</html>