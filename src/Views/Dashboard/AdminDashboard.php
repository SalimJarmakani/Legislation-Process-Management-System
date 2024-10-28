<?php

//get notifications 
require_once __DIR__ . "/../../Repositories/NotificationRepository.php";

$currentRole = isset($_SESSION["Role"]) ? $_SESSION["Role"] : "";

// Only allow Administrator to view this page
if ($currentRole != "Administrator") {
    header("Location: notFound");
}

$notiRepo = new NotificationRepository();
$notifications = $notiRepo->getAllNotificationsForUser($_SESSION["Id"]);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
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
            font-weight: bold;
        }

        .dashboard {
            padding: 20px;
        }

        h3 {
            color: #ff0000;
            font-size: 1.2rem;
            margin-bottom: 10px;
        }

        .bill-card {
            margin-bottom: 15px;
            border-radius: 5px;
            padding: 10px;
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .bill-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .vote-button {
            background: #ff0000;
            color: white;
            border: none;
            padding: 5px 10px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 0.875rem;
        }

        .vote-button:hover {
            background-color: #cc0000;
        }

        .sections {
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
        }

        .section {
            flex: 1;
            margin: 10px;
            min-width: 250px;
            border: 1px solid #ccc;
            border-radius: 10px;
            background-color: #fff;
            padding: 10px;
        }

        .draft {
            background-color: #e0e0e0;
        }

        .under-review {
            background-color: #cce5ff;
        }

        .approved {
            background-color: #d4edda;
        }

        .rejected {
            background-color: #f8d7da;
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
            <a href="#" data-toggle="modal" data-target="#logoutModal">Logout</a>
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
            <div class="sections">
                <!-- Draft Bills Section -->
                <div class="section">
                    <h3>Draft</h3>
                    <?php if (!empty($draftBills)): ?>
                        <?php foreach ($draftBills as $bill): ?>
                            <div class="bill-card draft">
                                <div class="bill-header">
                                    <div class="bill-title">
                                        <?php echo htmlspecialchars($bill->getTitle()); ?>
                                    </div>
                                    <p>Creation Date: <?php echo htmlspecialchars($bill->getCreatedTime()); ?></p>
                                    <form action="Bill/startBillVoting" method="POST" style="margin: 0;">
                                        <input type="hidden" name="billId" value="<?php echo htmlspecialchars($bill->getId()); ?>">
                                        <input type="submit" value="Initiate Voting" class="vote-button">
                                    </form>
                                </div>

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
                            <div class="bill-card under-review">
                                <div class="bill-header">
                                    <div class="bill-title">
                                        <?php echo htmlspecialchars($bill->getTitle()); ?>
                                    </div>
                                    <p>Creation Date: <?php echo htmlspecialchars($bill->getCreatedTime()); ?></p>
                                    <form action="Bill/BillAdmin" method="GET" style="margin: 0;">
                                        <input type="hidden" name="billId" value="<?php echo htmlspecialchars($bill->getId()); ?>">
                                        <input type="submit" value="End Voting Session" class="vote-button">
                                    </form>
                                </div>


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
                            <div class="bill-card approved">
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
                            <div class="bill-card rejected">
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

    <!-- Logout Confirmation Modal -->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="logoutModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="logoutModalLabel">Confirm Logout</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Are you sure you want to logout?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <a href="LogOut" class="btn btn-danger">Logout</a>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <footer>
        <p>&copy; 2024 Parliament System</p>
    </footer>
</body>

</html>