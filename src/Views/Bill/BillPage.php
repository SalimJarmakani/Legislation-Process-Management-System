<?php
require_once 'Views/layouts/NavBar.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bill Information</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #fff;
            color: #333;
        }

        .container {
            width: 80%;
            margin: auto;
            padding: 20px;
            background-color: #ffffff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 5px;
            border-left: 5px solid #d32f2f;
        }

        .section {
            margin-bottom: 25px;
        }

        .section h2 {
            color: #d32f2f;
            font-size: 20px;
            border-bottom: 2px solid #d32f2f;
            padding-bottom: 5px;
        }

        .content-box {
            padding: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            background-color: #fefefe;
        }

        .error-section {
            display: none;
            background-color: #ffebee;
            color: #b71c1c;
            border: 1px solid #d32f2f;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 15px;
            font-size: 14px;
        }

        .vote-container,
        .amendment-container {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            justify-content: space-between;
        }

        .vote-item,
        .amendment-item {
            flex: 1 1 30%;
            max-width: 30%;
            padding: 10px;
            border-radius: 5px;
            text-align: center;
            color: #fff;
            font-weight: bold;
        }

        /* Styling based on vote values */
        .vote-for {
            background-color: #4caf50;
            border: 1px solid #388e3c;
        }

        .vote-against {
            background-color: #d32f2f;
            border: 1px solid #b71c1c;
        }

        .vote-abstain {
            background-color: #9e9e9e;
            border: 1px solid #757575;
        }

        /* Amendment Styling */
        .amendment-item {
            background-color: #fff0f0;
            border: 1px solid #d32f2f;
            color: #333;
            font-weight: normal;
            padding: 15px;
            line-height: 1.6;
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
    <div class="container">
        <!-- Error Section -->
        <?php if (!empty($error)) : ?>
            <div class="error-section">
                <p><?php echo htmlspecialchars($error); ?></p>
            </div>
        <?php endif; ?>

        <!-- Bill Information Section -->
        <div class="section">
            <h2>Bill Information</h2>
            <div class="content-box">
                <p><strong>Title:</strong> <?php echo htmlspecialchars($bill->getTitle()); ?></p>
                <p><strong>Description:</strong> <?php echo htmlspecialchars($bill->getDescription()); ?></p>
                <p><strong>Author:</strong> <?php echo htmlspecialchars($bill->getUsername()); ?></p>
                <p><strong>Status:</strong> <?php echo htmlspecialchars($bill->getStatus()); ?></p>
                <p><strong>Created Time:</strong> <?php echo htmlspecialchars($bill->getCreatedTime()); ?></p>
                <p><strong>Updated Time:</strong> <?php echo htmlspecialchars($bill->getUpdatedTime()); ?></p>
                <p><strong>Draft Content:</strong> <?php echo htmlspecialchars($bill->getDraftContent()); ?></p>
            </div>
        </div>

        <!-- Votes Section -->
        <div class="section">
            <h2>Votes</h2>
            <?php if (!empty($votes)) : ?>
                <div class="vote-container">
                    <?php foreach ($votes as $vote) :
                        $voteClass = '';
                        if ($vote->getVoteValue() === 'For') {
                            $voteClass = 'vote-for';
                        } elseif ($vote->getVoteValue() === 'Against') {
                            $voteClass = 'vote-against';
                        } else {
                            $voteClass = 'vote-abstain';
                        }
                    ?>
                        <div class="vote-item <?php echo $voteClass; ?>">
                            <p><strong>MP:</strong> <?php echo htmlspecialchars($vote->getMpName()); ?></p>
                            <p><strong>Vote:</strong> <?php echo htmlspecialchars($vote->getVoteValue()); ?></p>
                            <p><strong>Voted on:</strong> <?php echo htmlspecialchars($vote->getCreatedTime()); ?></p>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else : ?>
                <p>No votes have been recorded for this bill yet.</p>
            <?php endif; ?>
        </div>

        <!-- Amendments Section -->
        <div class="section">
            <h2>Amendments</h2>
            <?php if (!empty($amendments)) : ?>
                <div class="amendment-container">
                    <?php foreach ($amendments as $amendment) : ?>
                        <div class="amendment-item">
                            <p><strong>Amendment by:</strong> <?php echo htmlspecialchars($amendment->getAuthorName()); ?></p>
                            <p><strong>Date:</strong> <?php echo htmlspecialchars($amendment->getCreatedTime()); ?></p>
                            <p><strong>Amendment:</strong> <?php echo htmlspecialchars($amendment->getAmendmentContent()); ?></p>
                            <p><strong>Comment:</strong> <?php echo htmlspecialchars($amendment->getComment()); ?></p>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else : ?>
                <p>No amendments have been made for this bill yet.</p>
            <?php endif; ?>
        </div>
    </div>

    <!-- Modal for Success/Error Messages -->
    <div id="messageModal" class="modal">
        <div class="modal-content">
            <span class="close-button" id="closeButton">&times;</span>
            <p id="modalMessage"></p>
            <button id="okButton">OK</button>
        </div>
    </div>

    <script>
        // Function to show the modal
        function showModal(message) {
            document.getElementById("modalMessage").textContent = message;
            document.getElementById("messageModal").style.display = "block";
        }

        // Close the modal when the user clicks the "OK" button
        document.getElementById("okButton").onclick = function() {
            document.getElementById("messageModal").style.display = "none";
        };

        // Close the modal when the user clicks the close button
        document.getElementById("closeButton").onclick = function() {
            document.getElementById("messageModal").style.display = "none";
        };

        // Close the modal if the user clicks outside of it
        window.onclick = function(event) {
            var modal = document.getElementById("messageModal");
            if (event.target === modal) {
                modal.style.display = "none";
            }
        };

        // Check for success or error messages and show the modal if any
        <?php if (!empty($success)) : ?>
            showModal("<?php echo htmlspecialchars($success); ?>");
        <?php endif; ?>
        <?php if (!empty($error)) : ?>
            showModal("<?php echo htmlspecialchars($error); ?>");
        <?php endif; ?>
    </script>
</body>

</html>