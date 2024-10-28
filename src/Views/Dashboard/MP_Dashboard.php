<?php
require_once __DIR__ . "/../../Repositories/NotificationRepository.php";

$currentRole = isset($_SESSION["Role"]) ? $_SESSION["Role"] : "";

if ($currentRole != "Administrator" && $currentRole != "MP") {
    header("Location: notFound");
    exit();
}
$notiRepo = new NotificationRepository();
$notifications = $notiRepo->getAllNotificationsForUser($_SESSION["Id"]);


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>MP Dashboard</title>
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
            background: #ffffff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px #000000;
        }

        h2 {
            color: #ff0000;
        }

        .section {
            margin: 20px 0;
        }

        .section h3 {
            background: #ff0000;
            color: #ffffff;
            padding: 10px;
            border-radius: 5px;
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

        .button-container {
            display: flex;
            gap: 10px;
        }

        .action-button {
            background-color: #ff0000;
            color: white;
            border: none;
            padding: 8px 12px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
        }

        footer {
            text-align: center;
            margin: 20px 0;
            color: #000000;
        }

        /* Modal Styles */
        .modal {
            display: none;
            /* Hidden by default */
            position: fixed;
            z-index: 1;
            /* Sit on top */
            left: 0;
            top: 0;
            width: 100%;
            /* Full width */
            height: 100%;
            /* Full height */
            overflow: auto;
            /* Enable scroll if needed */
            background-color: rgba(0, 0, 0, 0.4);
            /* Black w/ opacity */
        }

        .modal-content {
            background-color: #fefefe;
            margin: 15% auto;
            /* 15% from the top and centered */
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            /* Could be more or less, depending on screen size */
            text-align: center;
        }

        .close-button {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close-button:hover,
        .close-button:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
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
            <a href="Bill/AddBill">Add New Bill</a>
            <button id="logoutButton" class="action-button">Logout</button> <!-- Styled Logout Button -->
            <div class="dropdown">
                <button class="btn dropdown-toggle" type="button" id="notificationDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                    🔔 Notifications
                </button>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="notificationDropdown">
                    <?php foreach ($notifications as $notification) : ?>
                        <li>
                            <a class="dropdown-item <?php echo $notification->getIsRead() ? '' : 'unread'; ?>" href="#">
                                <p class="mb-1"><?php echo htmlspecialchars($notification->getMessage()); ?></p>
                                <small class="text-muted"><?php echo date("Y-m-d H:i", strtotime($notification->getCreatedTime())); ?></small>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </nav>
        <div class="dashboard">

            <!-- Pending Bills Section -->
            <div class="section">
                <h3>Pending Bills</h3>
                <?php
                // Filter bills that are in 'Draft' status
                $pendingBills = array_filter($bills, function ($bill) {
                    return $bill->getStatus() === 'Draft';
                });
                ?>
                <?php if (!empty($pendingBills)): ?>
                    <?php foreach ($pendingBills as $bill): ?>
                        <div class="bill-item">
                            <div class="bill-details">
                                <p><?php echo htmlspecialchars($bill->getTitle()) . " - Creation Date: " . htmlspecialchars($bill->getCreatedTime()); ?></p>
                            </div>
                            <div class="button-container">
                                <form action="Bill/EditBill" method="GET">
                                    <input type="hidden" name="billId" value="<?php echo htmlspecialchars($bill->getId()); ?>">
                                    <button type="submit" class="action-button">View/Edit</button>
                                </form>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>No pending bills available.</p>
                <?php endif; ?>
            </div>

            <!-- Under Review Bills Section -->
            <div class="section">
                <h3>Under Review Bills</h3>
                <?php
                // Filter bills that are in 'Under Review' status
                $underReviewBills = array_filter($bills, function ($bill) {
                    return $bill->getStatus() === 'Under Review';
                });
                ?>
                <?php if (!empty($underReviewBills)): ?>
                    <?php foreach ($underReviewBills as $bill): ?>
                        <div class="bill-item">
                            <div class="bill-details">
                                <p><?php echo htmlspecialchars($bill->getTitle()) . " - Creation Date: " . htmlspecialchars($bill->getCreatedTime()); ?></p>
                                <form action="Bill/Voting" method="GET">
                                    <input type="hidden" name="billId" value="<?php echo htmlspecialchars($bill->getId()); ?>">
                                    <button type="submit" class="action-button">Vote</button>
                                </form>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>No bills under review.</p>
                <?php endif; ?>
            </div>

            <!-- Accepted Bills Section -->
            <div class="section">
                <h3>Approved Bills</h3>
                <?php
                // Filter bills that are in 'Accepted' status
                $acceptedBills = array_filter($bills, function ($bill) {
                    return $bill->getStatus() === 'Approved';
                });
                ?>
                <?php if (!empty($acceptedBills)): ?>
                    <?php foreach ($acceptedBills as $bill): ?>
                        <div class="bill-item">
                            <div class="bill-details">
                                <p><?php echo htmlspecialchars($bill->getTitle()) . " - Created by: " . htmlspecialchars($bill->getUsername()) . " - Creation Date: " . htmlspecialchars($bill->getCreatedTime()); ?></p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>No accepted bills available.</p>
                <?php endif; ?>
            </div>

            <!-- Rejected Bills Section -->
            <div class="section">
                <h3>Rejected Bills</h3>
                <?php
                // Filter bills that are in 'Rejected' status
                $rejectedBills = array_filter($bills, function ($bill) {
                    return $bill->getStatus() === 'Rejected';
                });
                ?>
                <?php if (!empty($rejectedBills)): ?>
                    <?php foreach ($rejectedBills as $bill): ?>
                        <div class="bill-item">
                            <div class="bill-details">
                                <p><?php echo htmlspecialchars($bill->getTitle()) . " - Created by: " . htmlspecialchars($bill->getUsername()) . " - Creation Date: " . htmlspecialchars($bill->getCreatedTime()); ?></p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>No rejected bills available.</p>
                <?php endif; ?>
            </div>

        </div>
    </div>
    <footer>
        <p>&copy; 2024 Parliament System</p>
    </footer>

    <!-- Modal for Logout Confirmation -->
    <div id="logoutModal" class="modal">
        <div class="modal-content">
            <span class="close-button" id="closeModal">&times;</span>
            <p>Are you sure you want to log out?</p>
            <button id="confirmLogout" class="action-button">Yes</button>
            <button id="cancelLogout" class="action-button">No</button>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Get the modal
        var modal = document.getElementById("logoutModal");

        // Get the button that opens the modal
        var logoutButton = document.getElementById("logoutButton");

        // When the user clicks the button, open the modal 
        logoutButton.onclick = function() {
            modal.style.display = "block";
        }

        // Get the <span> element that closes the modal
        var span = document.getElementById("closeModal");

        // When the user clicks on <span> (x), close the modal
        span.onclick = function() {
            modal.style.display = "none";
        }

        // When the user clicks outside of the modal, close it
        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }

        // Confirm logout
        document.getElementById("confirmLogout").onclick = function() {
            window.location.href = "LogOut";
        }

        // Cancel logout
        document.getElementById("cancelLogout").onclick = function() {
            modal.style.display = "none";
        }
    </script>
</body>

</html>