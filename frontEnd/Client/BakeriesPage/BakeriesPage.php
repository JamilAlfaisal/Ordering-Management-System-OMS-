<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="/OMS/frontEnd/Client/BakeriesPage/BakeriesPage.css">
        <title>Document</title>
    </head>
    <body>
        <section class="appbar">
            <h2>Available Backeries</h2>
            <a href="/OMS/frontEnd/Client/RegistrationPage/Login.php">← Back</a>
        </section>
        <table border="1">
            <tr>
                <th>-</th>
                <th>Bakery Name</th>
                <th>ID</th>
            <tr>
            <?php foreach ($bakeries as $bakery): ?>
                <tr>
                    <td><a href="ProductsPage.php?bakery_id=<?php echo htmlspecialchars($bakery['Id']); ?>" target="_blank">SELECT</a></td>
                    <td><?php echo htmlspecialchars($bakery['name']); ?></td>
                    <td><?php echo htmlspecialchars($bakery['Id']); ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    </body>
</html>