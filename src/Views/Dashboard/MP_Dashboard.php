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
    <title>MP Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #ffffff;
            /* White background for the body */
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

        footer {
            text-align: center;
            margin: 20px 0;
            color: #000000;
            /* Black footer text */
        }

        .bill-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #f8f8f8;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ff0000;
            border-radius: 5px;
        }

        .bill-details {
            flex: 1;
        }

        .vote-button {
            background-color: #ff0000;
            color: white;
            border: none;
            padding: 8px 12px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
        }
    </style>
</head>

<body>
    <header>
        <h1>Member of Parliament Dashboard</h1>
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
                <?php if (!empty($bills)): ?>
                    <?php foreach ($bills as $bill): ?>
                        <div class="bill-item">
                            <div class="bill-details">
                                <p><?php echo htmlspecialchars($bill->getTitle()) . " - Creation Date: " . htmlspecialchars($bill->getCreatedTime()); ?></p>
                                <form action="Bill/Voting" method="GET">
                                    <input type="hidden" name="billId" value="<?php echo htmlspecialchars($bill->getId()); ?>">
                                    <button type="submit" class="vote-button">Vote</button>
                                </form>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>No pending bills available.</p>
                <?php endif; ?>
            </div>
            <div class="section">
                <h3>Voting Results</h3>
                <p>Last Vote: Bill Title A - Your Vote: Yes - Result: Passed</p>
                <p>Last Vote: Bill Title B - Your Vote: No - Result: Rejected</p>
            </div>
            <div class="section">
                <h3>Upcoming Sessions</h3>
                <p>Next Session: 2024-10-15</p>
                <p>Location: Parliament Hall, Room 202</p>
            </div>
            <div class="section">
                <h3>Constituency Issues</h3>
                <p>Issue 1: Concern about local infrastructure.</p>
                <p>Issue 2: Request for more funding for education.</p>
            </div>
        </div>
    </div>
    <footer>
        <p>&copy; 2024 Parliament System</p>
    </footer>
</body>

</html>