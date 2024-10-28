<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            color: #333;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .container {
            width: 400px;
            padding: 35px;
            border: 1px solid #ff0000;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .main-title {
            font-size: 25px;
            text-align: center;
            color: #ff0000;
            font-weight: bold;
            margin-bottom: 15px;
        }

        h2 {
            text-align: center;
            color: #ff0000;
            font-size: 24px;
            margin-bottom: 20px;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"],
        .role-selection input[type="radio"] {
            width: calc(100% - 20px);
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 5px;
            transition: border-color 0.3s ease;
        }

        input[type="text"]:focus,
        input[type="email"]:focus,
        input[type="password"]:focus {
            border-color: #ff6666;
        }

        input[type="submit"] {
            background-color: #ff0000;
            color: white;
            border: none;
            padding: 10px;
            width: 100%;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        input[type="submit"]:hover {
            background-color: #cc0000;
        }

        .role-selection {
            margin-top: 20px;
            margin-bottom: 20px;
            text-align: center;
        }

        .role-selection h3 {
            font-size: 18px;
            color: #333;
            margin-bottom: 10px;
        }

        .role-selection label {
            display: inline-block;
            margin: 0 10px;
            font-size: 16px;
            color: #555;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="main-title">Legislation System Registration</div>
        <form action="<?= $GLOBALS["BASE_URL"] ?>register" method="POST">
            <input type="text" name="name" placeholder="Name" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <div class="role-selection">
                <h3>Select Your Role:</h3>
                <label>
                    <input type="radio" name="role" value="MP" required> MP
                </label>
                <label>
                    <input type="radio" name="role" value="Administrator" required> Admin
                </label>
                <label>
                    <input type="radio" name="role" value="Reviewer" required> Reviewer
                </label>
            </div>
            <input type="submit" value="Register">
        </form>
    </div>
</body>

</html>