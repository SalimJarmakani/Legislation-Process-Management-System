<?php
require_once "././Repositories/NotificationRepository.php";
$notiRepo = new NotificationRepository();
$notifications = $notiRepo->getAllNotificationsForUser($_SESSION["Id"]);
// Ensure the user role is set
$currentRole = isset($_SESSION["Role"]) ? $_SESSION["Role"] : null;

// Set the home URL based on the user's role
if ($currentRole == "MP") {
    $homeURL = "MPDashboard"; // Redirect to MP dashboard
} elseif ($currentRole == "Reviewer") {
    $homeURL = "Rev-Dashboard"; // Redirect to Reviewer dashboard

} elseif ($currentRole == "Administrator") {
    $homeURL = "AdminDashboard";
} else {
    // Redirect to a default or not authorized page if role is missing/invalid
    header("Location: notFound.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #ffffff;
        }

        .app-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #ff0000;
            color: #ffffff;
            padding: 10px 20px;
            width: 98%;
            top: 0;
            z-index: 1000;
        }

        .app-bar button {
            background-color: transparent;
            border: none;
            color: #ffffff;
            cursor: pointer;
            font-size: 16px;
            padding: 10px;
            transition: background-color 0.3s ease;
        }

        .app-bar button:hover {
            background-color: rgba(255, 255, 255, 0.2);
        }

        .app-bar button:focus {
            outline: none;
        }

        .app-bar .back-button::before {
            content: '⬅';
            margin-right: 8px;
        }

        .app-bar .home-button::before {
            content: '🏠';
            margin-right: 8px;
        }

        .app-bar .logout-button::before {
            content: '🚪';
            margin-right: 8px;
        }

        /* Modal styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 1001;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            justify-content: center;
            align-items: center;
        }

        .modal-content {
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            text-align: center;
        }

        .modal-content p {
            margin-bottom: 20px;
        }

        .modal-content button {
            background-color: #ff0000;
            color: #ffffff;
            border: none;
            padding: 10px 20px;
            margin: 0 10px;
            cursor: pointer;
            font-size: 16px;
            border-radius: 5px;
        }

        .modal-content button:hover {
            background-color: #cc0000;
        }

        /* To ensure content doesn't get hidden under the fixed app bar */
        .content {
            margin-top: 60px;
        }

        /* Notification dropdown content */
        .dropdown-menu {
            max-height: 300px;
            overflow-y: auto;
            width: 300px;
        }

        .dropdown-item.unread {
            background-color: #f9f9f9;
            font-weight: bold;
        }
    </style>
</head>

<body>

    <div class="app-bar">
        <button class="back-button" onclick="goBack()">Back</button>
        <button class="home-button" onclick="goHome()">Home</button>
        <!-- Notification Dropdown using Bootstrap -->
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
        <button class="logout-button" onclick="showLogoutModal()">Logout</button>
    </div>

    <!-- Logout Modal -->
    <div id="logoutModal" class="modal">
        <div class="modal-content">
            <p>Are you sure you want to log out?</p>
            <button onclick="confirmLogout()">Yes, Logout</button>
            <button onclick="closeLogoutModal()">Cancel</button>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function goBack() {
            window.history.back();
        }

        function goHome() {
            // Redirect based on the home URL set in PHP
            window.location = "<?php echo $GLOBALS["BASE_URL"] . $homeURL; ?>";
        }

        // Show the logout modal
        function showLogoutModal() {
            document.getElementById("logoutModal").style.display = "flex";
        }

        // Close the logout modal
        function closeLogoutModal() {
            document.getElementById("logoutModal").style.display = "none";
        }

        // Confirm logout and redirect to logout page
        function confirmLogout() {
            window.location.href = "logout.php";
        }
    </script>

</body>

</html>