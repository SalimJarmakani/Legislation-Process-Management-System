<?php

//get notifications 
require_once __DIR__ . "/../../Repositories/NotificationRepository.php";

$currentRole = isset($_SESSION["Role"]) ? $_SESSION["Role"] : "";

if ($currentRole != "Reviewer") {
    header("Location: notFound");
    exit(); // Ensure exit after header redirect
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

        /* Modal styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            /* Black background with opacity */
        }

        .modal-content {
            background-color: #ffffff;
            margin: 15% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 300px;
            text-align: center;
            border-radius: 10px;
        }

        .modal button {
            padding: 10px;
            margin: 5px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .modal .ok-btn {
            background-color: #ff0000;
            color: white;
        }

        .modal .cancel-btn {
            background-color: #888;
            color: white;
        }
    </style>
</head>

<body>
    <header>
        <h1>Reviewer Dashboard</h1>
    </header>
    <div class="container">
        <h3 style="color:#ff0000"> <?= isset($error) ? $error : "" ?></h3>
        <nav>
            <a href="#">Home</a>
            <a href="#" id="logout-btn">Logout</a> <!-- Modified to trigger the modal -->
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

        <!-- The Logout Confirmation Modal -->
        <div id="logout-modal" class="modal">
            <div class="modal-content">
                <p>Are you sure you want to log out?</p>
                <button id="confirm-logout" class="ok-btn">OK</button>
                <button id="cancel-logout" class="cancel-btn">Cancel</button>
            </div>
        </div>

        <div class="dashboard">
            <!-- Pending Bills Section -->
            <div class="section">
                <h3>Pending Bills</h3>
                <div class="bills-container">
                    <?php if (!empty($bills)): ?>
                        <?php foreach ($bills as $bill): ?>
                            <?php if ($bill->getStatus() === 'Draft'): ?>
                                <div class="bill">
                                    <p><?php echo htmlspecialchars($bill->getTitle()) . " - Creation Date: " . htmlspecialchars($bill->getCreatedTime()); ?></p>
                                    <!-- Review Button for Draft Bills -->
                                    <form action="Bill/Review" method="GET">
                                        <input type="hidden" name="billId" value="<?php echo htmlspecialchars($bill->getId()); ?>">
                                        <button type="submit" class="button">Review Bill</button>
                                    </form>
                                </div>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p>No pending bills available.</p>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Bills Under Review Section -->
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

            <!-- Your Amendments Section -->
            <div class="section">
                <h3>Your Amendments</h3>
                <div class="bills-container">
                    <?php if (!empty($amendments)): ?>
                        <?php foreach ($amendments as $amendment): ?>
                            <div class="bill">
                                <p>
                                    <?php echo "Amendment to: " . htmlspecialchars($amendment->getBillName()) .
                                        " - Date: " . htmlspecialchars($amendment->getCreatedTime()); ?>
                                </p>
                                <p>
                                    <?php echo "Amendment Details: " . htmlspecialchars($amendment->getAmendmentContent()); ?>
                                </p>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p>No amendments made yet.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <footer>
            <p>&copy; 2024 Parliament System</p>
        </footer>

        <script>
            // Get elements
            const logoutBtn = document.getElementById("logout-btn");
            const modal = document.getElementById("logout-modal");
            const confirmLogout = document.getElementById("confirm-logout");
            const cancelLogout = document.getElementById("cancel-logout");

            // Show modal when logout is clicked
            logoutBtn.addEventListener("click", function(e) {
                e.preventDefault();
                modal.style.display = "block";
            });

            // If "OK" is clicked, redirect to logout
            confirmLogout.addEventListener("click", function() {
                window.location.href = "LogOut";
            });

            // If "Cancel" is clicked, hide the modal
            cancelLogout.addEventListener("click", function() {
                modal.style.display = "none";
            });

            // Close the modal if the user clicks outside of it
            window.addEventListener("click", function(event) {
                if (event.target == modal) {
                    modal.style.display = "none";
                }
            });
        </script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>