<?php
require_once __DIR__ . "/../layouts/NavBar.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create New Bill</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            color: #333;
        }

        .container {
            max-width: 600px;
            margin: 50px auto;
            padding: 30px;
            border: 1px solid #e9ecef;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            color: #dc3545;
            font-weight: bold;
        }

        input[type="text"],
        textarea {
            width: 100%;
            padding: 10px;
            margin: 15px 0;
            border: 1px solid #ced4da;
            border-radius: 5px;
        }

        input[type="submit"] {
            background-color: #dc3545;
            color: white;
            border: none;
            padding: 10px;
            width: 100%;
            border-radius: 5px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #c82333;
        }

        /* Modal Styling */
        .modal-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            justify-content: center;
            align-items: center;
        }

        .modal-content {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            width: 80%;
            max-width: 400px;
            text-align: center;
            position: relative;
        }

        .modal-close {
            position: absolute;
            top: 10px;
            right: 10px;
            background: none;
            border: none;
            font-size: 18px;
            cursor: pointer;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>Create New Bill</h2>
        <form action="<?= $GLOBALS["BASE_URL"] ?>Bill/CreateBill" method="POST">
            <input type="text" name="title" placeholder="Bill Title" required>
            <textarea name="description" placeholder="Bill Description" rows="5" required></textarea>
            <input type="text" name="draft" placeholder="Initial Draft (URL or file path)" required>
            <input type="submit" value="Create Bill">
        </form>
    </div>

    <!-- Modal Structure -->
    <div class="modal-overlay" id="notificationModal">
        <div class="modal-content">
            <button class="modal-close" id="closeModal">&times;</button>
            <h5>Notification</h5>
            <p><?= isset($message) && !empty($message) ? htmlspecialchars($message) : '' ?></p>
        </div>
    </div>

    <script>
        // JavaScript to handle modal display
        document.addEventListener("DOMContentLoaded", function() {
            const message = <?= json_encode(isset($message) && !empty($message)); ?>;
            const modal = document.getElementById('notificationModal');
            const closeModal = document.getElementById('closeModal');

            if (message) {
                modal.style.display = 'flex';
            }

            closeModal.addEventListener('click', function() {
                modal.style.display = 'none';
            });

            // Close modal when clicking outside the modal content
            window.addEventListener('click', function(event) {
                if (event.target === modal) {
                    modal.style.display = 'none';
                }
            });
        });
    </script>
</body>

</html>