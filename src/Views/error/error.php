<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <style>
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
    <h1><?= "Page Not Found: " . $error ?></h1>

    <a href="<?= $GLOBALS["BASE_URL"] ?>" class="btn">Return to HomePage</a>
</body>

</html>