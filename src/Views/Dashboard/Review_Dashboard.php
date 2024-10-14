<?php

$currentRole = $_SESSION["Role"];

if ($currentRole != "Reviewer" && $currentRole != "MP") {
    header("Location: notFound");
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

        .section p {
            background: #ffffff;
            /* White background for details */
            color: #ff0000;
            /* Red text for details */
            padding: 10px;
            border: 1px solid #ff0000;
            /* Red border for emphasis */
            border-radius: 5px;
            margin: 5px 0;
            /* Slight margin between paragraphs */
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
            <a href="#">Logout</a>
        </nav>
        <div class="dashboard">
            <div class="section">
                <h3>Pending Bills</h3>
                <?php if (!empty($bills)): ?>
                    <?php foreach ($bills as $bill): ?>
                        <p><?php echo htmlspecialchars($bill->getTitle()) . " - Creation Date: " . htmlspecialchars($bill->getCreatedTime()); ?></p>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>No pending bills available.</p>
                <?php endif; ?>
            </div>
            <div class="section">
                <h3>Your Amendments</h3>
                <?php if (!empty($amendments)): ?>
                    <?php foreach ($amendments as $amendment): ?>
                        <p><?php echo htmlspecialchars($amendment['comment']) . " - Created: " . htmlspecialchars($amendment['createdTime']) . " - Bill: " . htmlspecialchars($amendment['billName']); ?></p>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>No amendments made so far.</p>
                <?php endif; ?>
            </div>
            <div class="section">
                <h3>Add Amendment</h3>
                <form action="submitAmendment.php" method="POST">
                    <label for="billSelect">Select Bill:</label>
                    <select id="billSelect" name="billId">
                        <?php foreach ($bills as $bill): ?>
                            <option value="<?php echo htmlspecialchars($bill->getId()); ?>"><?php echo htmlspecialchars($bill->getTitle()); ?></option>
                        <?php endforeach; ?>
                    </select>
                    <br><br>
                    <label for="amendmentComment">Amendment Comment:</label>
                    <textarea id="amendmentComment" name="comment" required></textarea>
                    <br><br>
                    <input type="submit" value="Submit Amendment" style="background: #ff0000; color: white; border: none; padding: 10px; border-radius: 5px; cursor: pointer;">
                </form>
            </div>
        </div>
    </div>
    <footer>
        <p>&copy; 2024 Parliament System</p>
    </footer>
</body>

</html>