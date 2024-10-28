<?php

$currentRole = $_SESSION["Role"];
if ($currentRole != "Administrator") {
    header("Location: notFound");
    exit();
}

// Include the reusable navbar
include 'Views/layouts/NavBar.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bill Administration</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        .container {
            width: 80%;
            margin: auto;
            overflow: hidden;
            padding: 20px;
            background: #ffffff;
            border-radius: 5px;
            box-shadow: 0 0 10px #cccccc;
        }

        header {
            background: #ff0000;
            color: #ffffff;
            padding: 10px 0;
            text-align: center;
            border-radius: 5px 5px 0 0;
        }

        h2 {
            color: #ff0000;
        }

        .section {
            margin: 20px 0;
            padding: 15px;
            border: 1px solid #ff0000;
            border-radius: 5px;
            background-color: #f9f9f9;
        }

        .button-container {
            text-align: center;
            margin-top: 20px;
        }

        .action-button {
            background-color: #ff0000;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        .vote-container {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }

        .vote-item {
            flex: 1 1 calc(33.33% - 10px);
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 10px;
            border-radius: 5px;
            color: white;
            font-weight: bold;
        }

        .vote-for {
            background-color: green;
        }

        .vote-against {
            background-color: red;
        }

        .vote-abstain {
            background-color: grey;
        }

        footer {
            text-align: center;
            margin-top: 20px;
            color: #000000;
        }

        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.4);
        }

        .modal-content {
            background-color: #fefefe;
            margin: 15% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            border-radius: 5px;
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2><?php echo htmlspecialchars($bill->getTitle()); ?></h2>
        <div class="section">
            <h3>Bill Description</h3>
            <p><?php echo htmlspecialchars($bill->getDescription()); ?></p>
            <p><strong>Created On:</strong> <?php echo htmlspecialchars($bill->getCreatedTime()); ?></p>
            <p><strong>Draft:</strong> <?php echo htmlspecialchars($bill->getDraftContent()); ?></p>
        </div>

        <div class="section">
            <h3>Votes</h3>
            <div class="vote-container">
                <?php if (!empty($votes)): ?>
                    <?php foreach ($votes as $vote): ?>
                        <div class="vote-item 
                            <?php
                            if ($vote->getVoteValue() === 'For') echo 'vote-for';
                            elseif ($vote->getVoteValue() === 'Against') echo 'vote-against';
                            elseif ($vote->getVoteValue() === 'Abstain') echo 'vote-abstain';
                            ?>">
                            <?php echo htmlspecialchars($vote->getMpName()) . ': ' . htmlspecialchars($vote->getVoteValue()); ?>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>No votes recorded yet.</p>
                <?php endif; ?>
            </div>
        </div>

        <div class="button-container">
            <form action="EndVoting" method="POST">
                <input type="hidden" name="billId" value="<?php echo htmlspecialchars($bill->getId()); ?>">
                <button type="submit" class="action-button">End Voting Session</button>
            </form>
        </div>
    </div>

    <!-- Modal for error display -->
    <div id="errorModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal('errorModal')">&times;</span>
            <h3>Error</h3>
            <p id="errorMessage"><?php echo htmlspecialchars($error); ?></p>
        </div>
    </div>

    <!-- Modal for success message display -->
    <div id="messageModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal('messageModal')">&times;</span>
            <h3>Message</h3>
            <p id="successMessage"><?php echo htmlspecialchars($message); ?></p>
        </div>
    </div>

    <footer>
        <p>&copy; 2024 Parliament System</p>
    </footer>

    <script>
        // Show error modal if there is an error
        window.onload = function() {
            var errorMessage = "<?php if (!empty($error)) echo htmlspecialchars($error);  ?>";
            if (errorMessage) {
                document.getElementById('errorModal').style.display = 'block';
            }

            // Show success message modal if there is a message
            var successMessage = "<?php echo htmlspecialchars($message); ?>";

            if (successMessage) {
                document.getElementById('messageModal').style.display = 'block';
            }
        };

        // Function to close the modals
        function closeModal(modalId) {
            document.getElementById(modalId).style.display = 'none';
        }

        // Close the modal when the user clicks anywhere outside of it
        window.onclick = function(event) {
            var errorModal = document.getElementById('errorModal');
            var messageModal = document.getElementById('messageModal');
            if (event.target == errorModal) {
                errorModal.style.display = 'none';
            }
            if (event.target == messageModal) {
                messageModal.style.display = 'none';
            }
        };
    </script>
</body>

</html>