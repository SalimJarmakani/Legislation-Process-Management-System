<?php require_once __DIR__ . '/../../Views/layouts/NavBar.php'; ?>

<?php

$currentRole = $_SESSION["Role"];

if ($currentRole != "Administrator" && $currentRole != "MP") {
    header("Location: notFound");
    exit;
}
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
            margin: 0;
            padding: 0;
            background-color: #ffffff;
        }

        .container {
            width: 80%;
            margin: auto;
            overflow: hidden;
            padding: 20px;
        }

        h2 {
            color: #ff0000;
        }

        .bill-info {
            background-color: #f8f8f8;
            padding: 15px;
            border: 1px solid #ff0000;
            border-radius: 5px;
            margin-bottom: 20px;
        }

        .section {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin: 10px 0 5px;
        }

        /* Modal Styles */
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
            background-color: #fff;
            margin: 15% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 40%;
            border-radius: 10px;
            text-align: center;
        }

        .modal-content p {
            font-size: larger;
            color: orangered;
            margin-bottom: 20px;
        }

        .modal button {
            background-color: #ff0000;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s, transform 0.3s;
        }

        .modal button:hover {
            background-color: #cc0000;
            transform: scale(1.05);
        }

        /* Enhanced Amendment Section Styling */
        .amendment-info {
            background-color: #fff0f0;
            padding: 15px;
            border: 2px solid #ff0000;
            border-radius: 8px;
            margin-bottom: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s;
        }

        .amendment-info:hover {
            transform: scale(1.02);
        }

        .amendment-info h4 {
            margin: 0 0 5px 0;
            color: #ff0000;
        }

        .amendment-info p {
            margin: 5px 0;
            color: #333;
        }

        .amendment-info .timestamp {
            font-size: 12px;
            color: #666;
        }

        /* Heading for Amendments Section */
        h3 {
            color: #ff0000;
            border-bottom: 2px solid #ff0000;
            padding-bottom: 5px;
            margin-bottom: 20px;
        }

        /* Vote Section Styling */
        .vote-info {
            background-color: #e8f5e9;
            padding: 15px;
            border: 2px solid #4caf50;
            border-radius: 8px;
            margin-bottom: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s;
        }

        .vote-info:hover {
            transform: scale(1.02);
        }

        .vote-info h4 {
            margin: 0 0 5px 0;
            color: #4caf50;
        }

        .vote-info p {
            margin: 5px 0;
            color: #333;
        }

        .vote-info .timestamp {
            font-size: 12px;
            color: #666;
        }

        /* Styling for Vote Buttons */
        .vote-options {
            display: flex;
            gap: 10px;
        }

        .vote-label {
            cursor: pointer;
        }

        .vote-button {
            display: inline-block;
            background-color: #f5f5f5;
            border: 2px solid #d3d3d3;
            padding: 15px 25px;
            border-radius: 8px;
            font-size: 16px;
            transition: background-color 0.3s, border-color 0.3s, transform 0.3s;
        }

        .vote-button:hover {
            background-color: #ffcccc;
            border-color: #ff0000;
            transform: scale(1.1);
        }

        input[type="radio"] {
            display: none;
        }

        input[type="radio"]:checked+.vote-button {
            background-color: #ff0000;
            color: #ffffff;
            border-color: #ff0000;
        }

        /* Submit button styling */
        input[type="submit"] {
            background-color: #ff0000;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            margin-top: 20px;
            transition: background-color 0.3s, transform 0.3s;
        }

        input[type="submit"]:hover {
            background-color: #cc0000;
            transform: scale(1.05);
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>Bill Information</h2>

        <!-- Error Modal -->
        <?php if (!empty($error)): ?>
            <div id="errorModal" class="modal">
                <div class="modal-content">
                    <p><strong>Error:</strong> <?php echo htmlspecialchars($error); ?></p>
                    <button id="closeModal">OK</button>
                </div>
            </div>
        <?php endif; ?>

        <div class="bill-info">
            <p><strong>Title:</strong> <?php echo htmlspecialchars($bill->getTitle()); ?></p>
            <p><strong>Description:</strong> <?php echo htmlspecialchars($bill->getDescription()); ?></p>
            <p><strong>Author:</strong> <?php echo htmlspecialchars($bill->getUsername()); ?></p>
            <p><strong>Status:</strong> <?php echo htmlspecialchars($bill->getStatus()); ?></p>
            <p><strong>Created Time:</strong> <?php echo htmlspecialchars($bill->getCreatedTime()); ?></p>
            <p><strong>Updated Time:</strong> <?php echo htmlspecialchars($bill->getUpdatedTime()); ?></p>
        </div>

        <!-- Section: Voting on the Bill -->
        <div class="section">
            <h3>Cast Your Vote</h3>
            <form action="<?= $GLOBALS["BASE_URL"] ?>Bill/SubmitVote" method="POST" class="vote-form">
                <div class="vote-options">
                    <label class="vote-label">
                        <input type="radio" name="vote" value="For">
                        <span class="vote-button">For</span>
                    </label>
                    <label class="vote-label">
                        <input type="radio" name="vote" value="Against">
                        <span class="vote-button">Against</span>
                    </label>
                    <label class="vote-label">
                        <input type="radio" name="vote" value="Abstain">
                        <span class="vote-button">Abstain</span>
                    </label>
                </div>
                <input type="hidden" name="billId" value="<?php echo htmlspecialchars($bill->getId()); ?>">
                <input type="submit" value="Submit Vote">
            </form>
        </div>

        <!-- Section: Amendments to the Bill -->
        <div class="section">
            <h3>Amendments to This Bill</h3>

            <?php if (!empty($amendments)): ?>
                <?php foreach ($amendments as $amendment): ?>
                    <div class="amendment-info">
                        <h4>Amendment by: <?php echo htmlspecialchars($amendment->getAuthorName()); ?></h4>
                        <p><strong>Content:</strong> <?php echo htmlspecialchars($amendment->getAmendmentContent()); ?></p>
                        <p><strong>Comment:</strong> <?php echo htmlspecialchars($amendment->getComment()); ?></p>
                        <p class="timestamp"><strong>Created Time:</strong> <?php echo htmlspecialchars($amendment->getCreatedTime()); ?></p>
                        <p class="timestamp"><strong>Updated Time:</strong> <?php echo htmlspecialchars($amendment->getUpdatedTime()); ?></p>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No amendments have been made to this bill.</p>
            <?php endif; ?>
        </div>

        <!-- Section: Votes on the Bill -->
        <div class="section">
            <h3>Votes on This Bill</h3>

            <?php if (!empty($votes)): ?>
                <?php foreach ($votes as $vote): ?>
                    <div class="vote-info">
                        <h4>Vote by: <?php echo htmlspecialchars($vote->getMpName()); ?></h4>
                        <p><strong>Vote:</strong> <?php echo htmlspecialchars($vote->getVoteValue()); ?></p>
                        <p class="timestamp"><strong>Created Time:</strong> <?php echo htmlspecialchars($vote->getCreatedTime()); ?></p>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No votes have been recorded for this bill yet.</p>
            <?php endif; ?>
        </div>
    </div>

    <script>
        // JavaScript for Modal
        document.addEventListener("DOMContentLoaded", function() {
            var modal = document.getElementById("errorModal");
            var closeModalButton = document.getElementById("closeModal");

            if (modal) {
                modal.style.display = "block";

                closeModalButton.addEventListener("click", function() {
                    modal.style.display = "none";
                });
            }
        });
    </script>
</body>

</html>