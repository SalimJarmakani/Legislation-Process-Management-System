<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #fff;
            color: #333;
        }

        .container {
            width: 400px;
            margin: 0 auto;
            padding: 35px;
            border: 2px solid #ff0000;
            background-color: #ffcccc;
        }

        h2 {
            text-align: center;
            color: #ff0000;
        }

        input[type="text"],
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
        <h2>Register</h2>
        <form action="<?= $GLOBALS["BASE_URL"] ?>login" method="POST">
            <input type="text" name="name" placeholder="name" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <input type="submit" value="Register">
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
        </form>

    </div>
</body>

</html>