<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<style>
    :root {
        /* Define the standard height in one place */
        --header-height: 60px;
        --background-color: #f5f5f5;
        --button-color: #ED8C2B;
        --button-hover-color: #E5E0DB;
        --text-color: #171412;
    }
    * {
        box-sizing: border-box;
        margin: 0px;
        padding: 0px;
    }

    html, body{
        margin: 0px;
        padding: 0px;
        font-family: Arial, sans-serif;
    }
    .appbar{
        width: 100%;
        height: var(--header-height);
        /* background-color: var(--background-color); */
        padding: 0 20px;
        border-bottom: 1px solid #ccc;
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-direction: row;
        /* box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); */
    }
    .appbar a{
        text-decoration: none;
        color: var(--text-color);
        font-size: 16px;
    }
    form{
        display: flex;
        flex-direction: column;
        gap: 15px;
        padding-top: 100px;
        justify-content: center;
        align-self: center;
        align-items: center;
    }
    div{
        display: flex;
        flex-direction: column;
        gap: 5px;
    }
    input{
        padding: 8px;
        font-size: 14px;
        border: 1px solid #ccc;
        border-radius: 4px;
        width:  270px;
    }
    button{
        padding: 10px;
        font-size: 16px;
        background-color: var(--button-color);
        color: white;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        width: 270px;
    }
    button:hover{
        background-color: var(--button-hover-color);
        color: var(--text-color);
    }
</style>
<body>
    <div class="appbar">
        <h2>Available Backeries</h2>
        <a href="">Register</a>
    </div>
    <section from="form">
        <form action="/OMS/BackEnd/Backery/LoginLogic.php" method="post">
            <h2>Bakery login</h2>
            <div class="email">
                <label for="email">Username:</label>
                <input type="text" id="email" name="email" required placeholder="Enter your Email">
            </div>
            <div class="password">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required placeholder="Enter your Password">
            </div>
            <button type="submit">Login</button>
        </form>
    </section>
</body>
</html>