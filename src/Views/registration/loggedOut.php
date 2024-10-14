<?php
// Start session
session_start();

// Unset all session variables
session_unset();

// Destroy the session
session_destroy();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logged Out</title>
    <style>
        body {
            background-color: #f5f5f5;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .logout-container {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: white;
        }

        .logout-box {
            background-color: #ffffff;
            border: 2px solid #d9534f;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        h1 {
            color: #d9534f;
            font-size: 2rem;
            margin-bottom: 15px;
        }

        p {
            color: #333;
            font-size: 1rem;
            margin-bottom: 20px;
        }

        .close-instructions {
            color: #d9534f;
            font-weight: bold;
            font-size: 1.2rem;
        }

        .btn {
            background-color: #d9534f;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            font-size: 1rem;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .btn:hover {
            background-color: #c9302c;
        }
    </style>
</head>

<body>

    <div class="logout-container">
        <div class="logout-box">
            <h1>Logout Successful</h1>
            <p>You have been successfully logged out.</p>
            <p class="close-instructions">Please close all your browser tabs for security reasons.</p>
            <a href="loginPage" class="btn">Return to Login</a>
        </div>
    </div>

</body>

</html>