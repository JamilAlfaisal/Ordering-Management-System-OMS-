<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/OMS/frontEnd/Client/OrderStatuesPage/OrderStatusPage.css">
    <title>Document</title>
</head>
<body>
    <section class="appbar">
        <h2>Order Page</h2>
        <a href="/OMS/frontEnd/Client/Logout.php">🚪 Logout</a>
    </section>
    <section class="order-status-section">
        <div style="margin-left: 20px; margin-top: 20px;">
            <h1>Your Order Status</h1>
            <p>Your order is currently being processed. Please check back later for updates.</p>
            <table border="1">
                <tr>
                    <th>-</th>
                    <th>Order</th>
                    <th>Status</th>
                <tr>
                <?php for ($i = 0;$i<count($orders);$i++){ ?>
                    <tr>
                        <td><?php echo htmlspecialchars($orders[$i]['Id']) ?></td>
                        <td><?php echo htmlspecialchars($pastriesByOrder[$orders[$i]['Id']]) ?></td>
                        <td><?php echo htmlspecialchars($orders[$i]['status']) ?></td>
                    </tr>
                <?php }; ?>
            </table>
            <button onclick="location.reload()">⟳ Refresh</button>
        </div>
    </section>
</body>
</html>