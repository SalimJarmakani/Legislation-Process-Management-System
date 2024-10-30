<?php
//tests to check if we have a database and data 

require_once __DIR__ .  "/Repositories/UserRepository.php";
require_once __DIR__ .  "/Repositories/BillRepository.php";
$role = $_SESSION["Role"] ?? "";


//only admins can run these tests
if ($role != "Administrator") {

    header("Location: notFound");
    exit();
}


$billRepo = new BillRepository();
$userRepo = new UserRepository();

$user = $userRepo->getUserByEmail("mp@example.com");

$userAssert = assert($user->getEmail() == "mp@example.com");


$bills = $billRepo->getAllBills();


$billAssert = assert(count($bills) > 0);


// Array to store assertion results
$assertions = [
    "User with email mp@example.com exists" => $userAssert,
    "Bills are available in the database" => $billAssert
];
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Database and Data Test Results</title>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            margin: 0;
        }

        .container {
            text-align: center;
        }

        .result {
            display: inline-block;
            padding: 10px 20px;
            margin: 10px 0;
            border-radius: 5px;
            font-size: 1.2em;
            color: #fff;
        }

        .success {
            background-color: #4CAF50;
        }

        .failure {
            background-color: #f44336;
        }

        .back-button {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            color: #fff;
            background-color: #007BFF;
            text-decoration: none;
            border-radius: 5px;
            font-size: 1.1em;
        }

        .back-button:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Database and Data Test Results</h1>
        <?php foreach ($assertions as $description => $result): ?>
            <div class="result <?= $result ? 'success' : 'failure' ?>">
                <?= $description ?>: <?= $result ? "Passed" : "Failed" ?>
            </div>
        <?php endforeach; ?>

        <a href="AdminDashboard" class="back-button">Return to Admin Dashboard</a>
    </div>

</body>

</html>