<?php
session_start();

// Ensure the user role is set
$currentRole = isset($_SESSION["Role"]) ? $_SESSION["Role"] : null;

// Set the home URL based on the user's role
if ($currentRole == "MP") {
    $homeURL = "MPDashboard"; // Redirect to MP dashboard
} elseif ($currentRole == "Reviewer") {
    $homeURL = "Rev-Dashboard"; // Redirect to Reviewer dashboard
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
    <title>App Bar</title>
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
            position: fixed;
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
    </style>
</head>

<body>

    <div class="app-bar">
        <button class="back-button" onclick="goBack()">Back</button>
        <button class="home-button" onclick="goHome()">Home</button>
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