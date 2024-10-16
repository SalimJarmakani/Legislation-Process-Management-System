<?php

$currentRole = $_SESSION["Role"];

if ($currentRole != "Administrator" && $currentRole != "MP") {
    header("Location: notFound");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bill Information</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #ffffff;
        }

        .container {
            width: 80%;
            margin: auto;
            overflow: hidden;
            padding: 20px;
        }

        h2 {
            color: #ff0000;
        }

        .bill-info {
            background-color: #f8f8f8;
            padding: 15px;
            border: 1px solid #ff0000;
            border-radius: 5px;
            margin-bottom: 20px;
        }

        .section {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin: 10px 0 5px;
        }

        input[type="submit"] {
            background-color: #ff0000;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
        }

        .error {
            color: red;
            margin-bottom: 10px;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>Bill Information</h2>

        <div class="bill-info">
            <p><strong>Title:</strong> <?php echo htmlspecialchars($bill->getTitle()); ?></p>
            <p><strong>Description:</strong> <?php echo htmlspecialchars($bill->getDescription()); ?></p>
            <p><strong>Author:</strong> <?php echo htmlspecialchars($bill->getUsername()); ?></p> <!-- Assuming the username is fetched from a user table -->
            <p><strong>Status:</strong> <?php echo htmlspecialchars($bill->getStatus()); ?></p>
            <p><strong>Created Time:</strong> <?php echo htmlspecialchars($bill->getCreatedTime()); ?></p>
            <p><strong>Updated Time:</strong> <?php echo htmlspecialchars($bill->getUpdatedTime()); ?></p>
        </div>

        <!-- Additional Section: Voting on the Bill -->
        <div class="section">
            <h3>Cast Your Vote</h3>
            <form action="voting.php" method="POST">
                <label>
                    <input type="radio" name="vote" value="For"> For
                </label>
                <label>
                    <input type="radio" name="vote" value="Against"> Against
                </label>
                <label>
                    <input type="radio" name="vote" value="Abstain"> Abstain
                </label>
                <input type="hidden" name="billId" value="<?php echo htmlspecialchars($bill->getId()); ?>">
                <input type="submit" value="Submit Vote">
            </form>
        </div>
    </div>
</body>

</html>