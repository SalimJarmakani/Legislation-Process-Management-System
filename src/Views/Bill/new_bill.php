<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create New Bill</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #fff;
            color: #333;
        }

        .container {
            width: 500px;
            margin: 0 auto;
            padding: 20px;
            border: 2px solid #ff0000;
            background-color: #ffcccc;
            border-radius: 5px;
        }

        h2 {
            text-align: center;
            color: #ff0000;
        }

        input[type="text"],
        input[type="textarea"] {
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
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #cc0000;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>Create New Bill</h2>
        <form method="POST" action="submit_bill.php"> <!-- Replace with your submission handler -->
            <input type="text" name="title" placeholder="Bill Title" required><br>
            <textarea name="description" placeholder="Bill Description" rows="5" required></textarea><br>
            <input type="text" name="author" placeholder="Author Name" required><br>
            <input type="text" name="initial_draft" placeholder="Initial Draft (URL or file path)" required><br>
            <input type="submit" value="Create Bill">
        </form>
    </div>
</body>

</html>