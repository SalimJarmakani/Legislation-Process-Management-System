<?php

$currentRole = $_SESSION["Role"];

// Only allow Administrator to view this page
if ($currentRole != "Administrator") {
    header("Location: notFound");
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #ffffff;
        }

        header {
            background: #ff0000;
            color: #ffffff;
            padding: 10px 0;
            text-align: center;
        }

        nav {
            margin: 20px 0;
        }

        nav a {
            margin: 0 15px;
            color: #ff0000;
            text-decoration: none;
        }

        .dashboard {
            padding: 20px;
        }

        h3 {
            color: #ff0000;
            font-size: 1rem;
            /* Smaller heading */
        }

        .bill-card {
            margin-bottom: 15px;
            border: 1px solid #ff0000;
            border-radius: 5px;
            padding: 10px;
            background-color: #fff;
        }

        .vote-button {
            background: #ff0000;
            color: white;
            border: none;
            padding: 5px 10px;
            /* Smaller button */
            border-radius: 5px;
            cursor: pointer;
            font-size: 0.875rem;
            /* Smaller font */
        }

        .vote-button:hover {
            background-color: #cc0000;
        }

        /* Flexbox layout for columns */
        .sections {
            display: flex;
            justify-content: space-between;
        }

        .section {
            flex: 1;
            margin: 10px;
        }
    </style>
</head>

<body>
    <header>
        <h1>Admin Dashboard</h1>
    </header>
    <div class="container">
        <nav>
            <a href="#">Home</a>
            <a href="#">Profile</a>
            <a href="LogOut">Logout</a>
        </nav>
        <div class="dashboard">
            <!-- Flexbox layout for four status columns -->
            <div class="sections">
                <!-- Draft Bills Section -->
                <div class="section">
                    <h3>Draft</h3>
                    <?php if (!empty($draftBills)): ?>
                        <?php foreach ($draftBills as $bill): ?>
                            <div class="bill-card">
                                <div class="bill-header">
                                    <div class="bill-title">
                                        <?php echo htmlspecialchars($bill->getTitle()); ?>
                                    </div>
                                    <form action="Bill/startBillVoting" method="POST" style="margin: 0;">
                                        <input type="hidden" name="billId" value="<?php echo htmlspecialchars($bill->getId()); ?>">
                                        <input type="submit" value="Initiate Voting" class="vote-button">
                                    </form>
                                </div>
                                <p>Creation Date: <?php echo htmlspecialchars($bill->getCreatedTime()); ?></p>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p>No draft bills available.</p>
                    <?php endif; ?>
                </div>

                <!-- Under Review Bills Section -->
                <div class="section">
                    <h3>Under Review</h3>
                    <?php if (!empty($underReviewBills)): ?>
                        <?php foreach ($underReviewBills as $bill): ?>
                            <div class="bill-card">
                                <div class="bill-header">
                                    <div class="bill-title">
                                        <?php echo htmlspecialchars($bill->getTitle()); ?>
                                    </div>
                                </div>
                                <p>Creation Date: <?php echo htmlspecialchars($bill->getCreatedTime()); ?></p>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p>No bills under review.</p>
                    <?php endif; ?>
                </div>

                <!-- Approved Bills Section -->
                <div class="section">
                    <h3>Approved</h3>
                    <?php if (!empty($approvedBills)): ?>
                        <?php foreach ($approvedBills as $bill): ?>
                            <div class="bill-card">
                                <div class="bill-header">
                                    <div class="bill-title">
                                        <?php echo htmlspecialchars($bill->getTitle()); ?>
                                    </div>
                                </div>
                                <p>Creation Date: <?php echo htmlspecialchars($bill->getCreatedTime()); ?></p>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p>No approved bills available.</p>
                    <?php endif; ?>
                </div>

                <!-- Rejected Bills Section -->
                <div class="section">
                    <h3>Rejected</h3>
                    <?php if (!empty($rejectedBills)): ?>
                        <?php foreach ($rejectedBills as $bill): ?>
                            <div class="bill-card">
                                <div class="bill-header">
                                    <div class="bill-title">
                                        <?php echo htmlspecialchars($bill->getTitle()); ?>
                                    </div>
                                </div>
                                <p>Creation Date: <?php echo htmlspecialchars($bill->getCreatedTime()); ?></p>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p>No rejected bills available.</p>
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