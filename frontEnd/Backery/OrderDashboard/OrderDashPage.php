<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Order Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #fafafa;
            margin: 0;
            padding: 0;
        }

        header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px 40px;
            background: white;
            border-bottom: 1px solid #ddd;
        }

        header h1 {
            display: flex;
            align-items: center;
            font-size: 20px;
            font-weight: bold;
            margin: 0;
        }

        header h1 span {
            margin-left: 10px;
        }

        .btn {
            padding: 10px 18px;
            border-radius: 8px;
            border: none;
            cursor: pointer;
            font-size: 14px;
            font-weight: bold;
        }

        .refresh {
            background: #ffb347;
            color: white;
        }

        .signout {
            background: #eee;
        }

        h2 {
            margin: 40px;
            font-size: 32px;
        }

        table {
            margin: 0 40px 60px 40px;
            width: calc(100% - 80px);
            border-collapse: collapse;
            background: white;
            border-radius: 10px;
            overflow: hidden;
        }

        th, td {
            padding: 18px;
            text-align: left;
            border-bottom: 1px solid #eee;
            font-size: 14px;
        }

        th {
            background: #f7f7f7;
            font-weight: bold;
        }

        .status {
            padding: 8px 12px;
            border-radius: 8px;
            display: inline-block;
            font-size: 13px;
            font-weight: bold;
            color: #444;
            background: #f1e9e4;
        }

        .inprocess {
            background: #eae4dc;
        }

        .action {
            color: #8a4f30;
            font-weight: bold;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <header>
        <h1>★ <span>Artisan Bakery OMS</span></h1>
        <div>
            <button class="btn refresh" onclick="location.reload()">Refresh Orders</button>
            <a href="/OMS/frontEnd/Client/Logout.php">Logout</a>
        </div>
    </header>

    <h2>Order Dashboard</h2>

    <table>
        <tr>
            <th>Order Number</th>
            <th>Customer Name</th>
            <th>Items Ordered</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
        <?php foreach ($orders as $order): ?>
            <tr>
                <td><?php echo htmlspecialchars($order['Id']); ?></td>
                <!-- This now correctly displays the customer's name because the PHP aliases u.Name as UserId -->
                <td><?php echo htmlspecialchars($order['UserId']); ?></td> 
                <td>
                    <?php
                        // Safely retrieve items for the current Order ID
                        $items = isset($pastries[$order['Id']]) ? $pastries[$order['Id']] : [];
                        if (empty($items)) {
                            echo "No items found.";
                        } else {
                            foreach ($items as $item) {
                                echo htmlspecialchars($item['Item']) . " (x" . htmlspecialchars($item['Number']) . ")<br/>";
                            }
                        }
                    ?>
                </td>
                <td>
                    <?php
                        $statusClass = '';
                        if ($order['status'] === 'In Process') {
                            $statusClass = 'inprocess';
                        }
                            $order_id = htmlspecialchars($order['Id']);
    
                      // Securely encode the status value for safe transmission in the URL
                      $status_url_encoded = urlencode($order['status']); 
                      
                      // Construct the clean, secure URL using PHP concatenation
                      $url = "/OMS/BackEnd/Backery/UpdateOrderStatus.php?Order_Id={$order_id}&status={$status_url_encoded}";
                    ?>
                    <a href="<?php echo $url; ?>">
                        <!-- Use htmlspecialchars for outputting the text in the browser -->
                        <span class="status <?php echo $order['status'] === 'In Process' ? 'inprocess' : ''; ?>">
                            <?php echo htmlspecialchars($order['status']); ?>
                        </span>
                    </a>
                </td>
                <td><span class="action">Update Status</span></td>
            </tr>
        <?php endforeach; ?>
        <?php if (empty($orders)): ?>
            <tr>
                <td colspan="5" style="text-align: center; color: #888; padding: 20px;">No new orders found for this bakery.</td>
            </tr>
        <?php endif; ?>
    </table>
</body>
</html>