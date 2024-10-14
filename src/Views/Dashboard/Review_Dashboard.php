<?php

$currentRole = $_SESSION["Role"];

if ($currentRole != "Reviewer" && $currentRole != "MP") {
    header("Location: /notFound");
    exit(); // Ensure exit after header redirect
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reviewer Dashboard</title>
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
        }

        header {
            background: #ff0000;
            /* Red header */
            color: #ffffff;
            /* White text */
            padding: 10px 0;
            text-align: center;
        }

        nav {
            margin: 20px 0;
        }

        nav a {
            margin: 0 15px;
            color: #ff0000;
            /* Red links */
            text-decoration: none;
        }

        .dashboard {
            background: #ffffff;
            /* White dashboard background */
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px #000000;
            /* Black shadow */
        }

        h2 {
            color: #ff0000;
            /* Red headings */
        }

        .section {
            margin: 20px 0;
        }

        .section h3 {
            background: #ff0000;
            /* Red section headers */
            color: #ffffff;
            /* White text */
            padding: 10px;
            border-radius: 5px;
        }

        .bills-container {
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
            /* Allow wrapping for smaller screens */
        }

        .bill {
            background: #ffffff;
            /* White background for bills */
            color: #ff0000;
            /* Red text for bills */
            padding: 10px;
            border: 1px solid #ff0000;
            /* Red border for emphasis */
            border-radius: 5px;
            margin: 5px;
            flex: 1 1 45%;
            /* Flex grow and shrink, with a basis of 45% */
            box-shadow: 0 0 5px #000000;
            /* Slight shadow for better visibility */
            text-align: center;
        }

        .button {
            background: #ff0000;
            /* Red button */
            color: white;
            border: none;
            padding: 5px 10px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 0.9em;
            /* Smaller font */
            margin-top: 10px;
        }
    </style>
</head>

<body>
    <header>
        <h1>Reviewer Dashboard</h1>
    </header>
    <div class="container">
        <nav>
            <a href="#">Home</a>
            <a href="#">Profile</a>
            <a href="Bill/AddBill">Add New Bill</a>
            <a href="LogOut">Logout</a>
        </nav>
        <div class="dashboard">
            <div class="section">
                <h3>Pending Bills</h3>
                <div class="bills-container">
                    <?php if (!empty($bills)): ?>
                        <?php foreach ($bills as $bill): ?>
                            <?php if ($bill->getStatus() === 'Draft'): ?>
                                <div class="bill">
                                    <p><?php echo htmlspecialchars($bill->getTitle()) . " - Creation Date: " . htmlspecialchars($bill->getCreatedTime()); ?></p>
                                </div>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p>No pending bills available.</p>
                    <?php endif; ?>
                </div>
            </div>
            <div class="section">
                <h3>Bills Under Review</h3>
                <div class="bills-container">
                    <?php if (!empty($bills)): ?>
                        <?php foreach ($bills as $bill): ?>
                            <?php if ($bill->getStatus() === 'Under Review'): ?>
                                <div class="bill">
                                    <p><?php echo htmlspecialchars($bill->getTitle()) . " - Creation Date: " . htmlspecialchars($bill->getCreatedTime()); ?></p>
                                    <form action="Bill/Review" method="GET">
                                        <input type="hidden" name="billId" value="<?php echo htmlspecialchars($bill->getId()); ?>">
                                        <button type="submit" class="button">Review Bill</button>
                                    </form>
                                </div>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p>No bills under review available.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    <footer>
        <p>&copy; 2024 Parliament System</p>
    </footer>
</body>

</html>