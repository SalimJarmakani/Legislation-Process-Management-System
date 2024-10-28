<?php

// Ensure the user role is set and valid
$currentRole = isset($_SESSION["Role"]) ? $_SESSION["Role"] : null;

if ($currentRole != "Reviewer" && $currentRole != "MP") {
    header("Location: /notFound");
    exit(); // Ensure exit after header redirect
}

// Include the reusable navbar
require_once __DIR__ . '/../../Views/layouts/NavBar.php';
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
            font-size: 14px;
        }

        .container {
            width: 80%;
            margin: auto;
            overflow: hidden;
            padding: 15px;
        }

        h2 {
            color: #ff0000;
            font-size: 18px;
        }

        .bill-info {
            background: #f8f8f8;
            border: 1px solid #ff0000;
            border-radius: 5px;
            padding: 10px;
            margin-bottom: 15px;
        }

        .section {
            margin: 15px 0;
        }

        label {
            display: block;
            margin: 8px 0 4px;
        }

        textarea {
            width: 100%;
            height: 80px;
            border-radius: 5px;
            border: 1px solid #ccc;
            padding: 8px;
            font-size: 12px;
        }

        input[type="submit"] {
            background: #ff0000;
            color: white;
            border: none;
            padding: 8px 12px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
        }

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
    </style>
</head>

<body>
    <!-- Container after the navbar -->
    <div class="container">
        <h3 style="color: #ff0000;"><?= isset($error) ? $error : "" ?></h3>
        <h2>Bill Information</h2>
        <div class="bill-info">
            <p><strong>Title:</strong> <?php echo htmlspecialchars($bill->getTitle()); ?></p>
            <p><strong>Description:</strong> <?php echo htmlspecialchars($bill->getDescription()); ?></p>
            <p><strong>Author:</strong> <?php echo htmlspecialchars($bill->getUsername()); ?></p>
            <p><strong>Status:</strong> <?php echo htmlspecialchars($bill->getStatus()); ?></p>
            <p><strong>Created Time:</strong> <?php echo htmlspecialchars($bill->getCreatedTime()); ?></p>
            <p><strong>Updated Time:</strong> <?php echo htmlspecialchars($bill->getUpdatedTime()); ?></p>
        </div>

        <div class="section">
            <h3>Votes</h3>

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

        <!-- Bill Amendments Section -->
        <div class="section">
            <h3>Bill Amendments</h3>
            <div class="amendments-container">
                <?php if (!empty($amendments)): ?>
                    <?php foreach ($amendments as $amendment): ?>
                        <div class="amendment">
                            <p><strong>Amendment by:</strong> <?php echo htmlspecialchars($amendment->getAuthorName()); ?></p>
                            <p><strong>Date:</strong> <?php echo htmlspecialchars($amendment->getCreatedTime()); ?></p>
                            <p><strong>Amendment:</strong> <?php echo htmlspecialchars($amendment->getAmendmentContent()); ?></p>
                            <p><strong>Comment:</strong> <?php echo htmlspecialchars($amendment->getComment()); ?></p>
                            <hr style="border: 1px solid #ff0000;">
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>No amendments have been made for this bill.</p>
                <?php endif; ?>
            </div>
        </div>

        <!-- Add Amendment and Comment Section -->
        <div class="section">
            <h3>Add Amendment</h3>
            <form action="AddAmendment" method="POST">
                <label for="amendment">Your Amendment:</label>
                <textarea id="amendment" name="amendment" required></textarea>

                <h3>Add Comment</h3>
                <label for="comment">Your Comment:</label>
                <textarea id="comment" name="comment" required></textarea>

                <input type="hidden" name="billId" value="<?php echo htmlspecialchars($bill->getId()); ?>">
                <input type="submit" value="Submit Amendment and Comment" style="margin-top: 20px;">
            </form>
        </div>
    </div>
</body>

</html>