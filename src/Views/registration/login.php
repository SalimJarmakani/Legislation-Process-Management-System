<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #fff;
            color: #333;
        }

        .container {
            width: 400px;
            margin: 0 auto;
            padding: 20px;
            border: 2px solid #ff0000;
            background-color: #ffcccc;
        }

        h2 {
            text-align: center;
            color: #ff0000;
        }

        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ff0000;
            border-radius: 5px;
        }

        input[type="submit"] {
            background-color: #ff0000;
            color: white;
            border: none;
            padding: 10px;
            width: 100%;
            border-radius: 5px;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>Login</h2>
        <form action="<?= $GLOBALS["BASE_URL"] ?>login" method="POST">
            <input type="email" name="email" placeholder="Email" required><br>
            <input type="password" name="password" placeholder="Password" required><br>
            <input type="submit" value="Login">
        </form>
    </div>

    <div>
        <h2><?= isset($error) && !empty($error) ? $error : "" ?></h2>
    </div>
</body>

</html>