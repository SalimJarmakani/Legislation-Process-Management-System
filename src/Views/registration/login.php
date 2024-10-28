<?php
$loggedIn = isset($_COOKIE["LoggedIn"]) ? $_COOKIE["LoggedIn"] : false;
$email = isset($_COOKIE["Email"]) ? $_COOKIE["Email"] : "";

// Check if the user is logged in and redirect based on the role
$Role = isset($_SESSION["Role"]) ? $_SESSION["Role"] : "";
switch (trim($Role)) {
    case 'MP':
        header("Location: MPDashboard");
        exit;
    case 'Reviewer':
        header("Location: Rev-Dashboard");
        exit;
    case 'Administrator':
        header("Location: AdminDashboard");
        exit;
    default:
        break;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f9f9f9;
            color: #333;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            height: 100vh;
            margin: 0;
        }

        .container {
            max-width: 400px;
            padding: 30px;
            border-radius: 10px;
            background-color: #fff;
            box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.1);
            border-top: 5px solid #ff0000;
        }

        h1 {
            color: #ff0000;
            font-size: 2.2rem;
            text-align: center;
            margin-bottom: 30px;
        }

        h2 {
            text-align: center;
            color: #ff0000;
            font-size: 1.8rem;
            margin-bottom: 20px;
        }

        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
            font-size: 1rem;
        }

        input[type="submit"] {
            background-color: #ff0000;
            color: white;
            border: none;
            padding: 12px;
            width: 100%;
            border-radius: 5px;
            font-size: 1rem;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        input[type="submit"]:hover {
            background-color: #d40000;
        }

        .remember-me {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }

        .remember-me input[type="checkbox"] {
            margin-right: 10px;
        }

        .error-message {
            text-align: center;
            color: #ff0000;
            font-size: 1rem;
            margin-top: 15px;
        }

        .forgot-password {
            display: block;
            text-align: right;
            margin-top: 10px;
            font-size: 0.9rem;
        }

        .forgot-password a {
            color: #ff0000;
            text-decoration: none;
        }

        .forgot-password a:hover {
            text-decoration: underline;
        }

        footer {
            text-align: center;
            margin-top: 20px;
            font-size: 0.9rem;
            color: #888;
        }
    </style>
</head>

<body>
    <h1>Welcome to Legislation Management System</h1>

    <div class="container">
        <h2>Login</h2>
        <form action="<?= $GLOBALS["BASE_URL"] ?>login" method="POST">
            <input type="email" name="email" placeholder="Email" value="<?= htmlspecialchars($email) ?>" required>
            <input type="password" name="password" placeholder="Password" required>

            <div class="remember-me">
                <input type="checkbox" name="remember" id="remember" <?= $loggedIn ? "checked" : "" ?>>
                <label for="remember">Remember Me</label>
            </div>

            <div style="margin-top:5px; margin-bottom:15px">
                <a href="registration">Don't have an account, click here to register</a>
            </div>

            <input type="submit" value="Login">
        </form>

        <div class="error-message">
            <?= isset($error) && !empty($error) ? $error : "" ?>
        </div>
    </div>

    <footer>
        &copy; 2024 Legislation Management System. All rights reserved.
    </footer>
</body>

</html>