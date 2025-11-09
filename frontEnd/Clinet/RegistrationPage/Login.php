<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <Link rel="stylesheet" href="Login.css">
    <script src="Login.js" defer></script>
    <title>Login</title>
</head>
<body>
    <section class="appbar">
            <h2>Client Login</h2>
            <a href="../../index.php">← Back</a>
    </section>
    <section class="loginForm">
        <form action="../../../BackEnd/ClientBackend/LoginLogic.php" method="POST">
            <label for="name">Name:</label>
            <input type="text" id="name" placeholder="Enter your name" name="name" required>

            <label for="Phone">Phone:</label>
            <input type="text" id="Phone" placeholder="Enter your Phone Number" name="Phone" required>

            <button type="submit">Login</button>
        </form>
    </section>
</body>
</html>