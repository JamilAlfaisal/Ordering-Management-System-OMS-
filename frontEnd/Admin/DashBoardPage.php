<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/OMS/frontEnd/Admin/DashBoardPage.css">
    <title>Admin</title>
</head>
<body>
    <section class="appbar">
        <h2>Admin Page</h2>
        <a href="/OMS/frontEnd/Client/Logout.php">🚪 Logout</a>
    </section>
    <section class="dashboard-section">
        <div class="dashboard-container">
            <h1>Welcome, Admin!</h1>
            <h2>Registered Bakeries</h2>
            <table>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Is Active</th>
                    <th>Deactivate</th>
                </tr>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row['Id']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['Name']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['Email']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['role']) . "</td>";
                        echo "<td>" . ($row['IsActive'] ? 'Yes' : 'No') . "</td>";
                        echo "<td><a 
                            href='/OMS/BackEnd/Admin/ToggleBakeryStatus.php?bakery_id=" . urlencode($row['Id']) . "&IsActive=" . $row['IsActive'] . "'
                            >" . ($row['IsActive'] ? 'Deactivate' : 'Activate') . "</a></td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='4'>No bakeries found.</td></tr>";
                }
                ?>
            </table><br><br>

            <h2>People who made orders</h2>
            <table>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>phone</th>
                    <th>Delete</th>
                </tr>
                <?php
                if ($resultUsers->num_rows > 0) {
                    while ($row = $resultUsers->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row['Id']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['Name']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['PhoneNumber']) . "</td>";
                        echo "<td><a href='/OMS/BackEnd/Admin/DeleteUsers.php?user_id=".urlencode($row['Id']) ."'>Delete</a></td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='3'>No users found.</td></tr>";
                }
                ?>
            </table>
        </div>
</body>
</html>