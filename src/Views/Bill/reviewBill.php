<?php

$currentRole = $_SESSION["Role"];

if ($currentRole != "Reviewer" && $currentRole != "MP") {
    header("Location: /notFound");
    exit(); // Ensure exit after header redirect
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
            font-size: 14px;
            /* Smaller font size */
        }

        .container {
            width: 80%;
            margin: auto;
            overflow: hidden;
            padding: 15px;
            /* Reduced padding */
        }

        h2 {
            color: #ff0000;
            /* Red heading */
            font-size: 18px;
            /* Smaller heading size */
        }

        .bill-info {
            background: #f8f8f8;
            border: 1px solid #ff0000;
            /* Red border */
            border-radius: 5px;
            padding: 10px;
            /* Reduced padding */
            margin-bottom: 15px;
            /* Reduced margin */
        }

        .section {
            margin: 15px 0;
            /* Reduced margin */
        }

        label {
            display: block;
            margin: 8px 0 4px;
            /* Reduced margins */
        }

        textarea {
            width: 100%;
            height: 80px;
            /* Reduced height */
            border-radius: 5px;
            border: 1px solid #ccc;
            padding: 8px;
            /* Reduced padding */
            font-size: 12px;
            /* Smaller text area font size */
        }

        input[type="submit"] {
            background: #ff0000;
            color: white;
            border: none;
            padding: 8px 12px;
            /* Reduced padding */
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
            /* Smaller button font size */
        }
    </style>
</head>

<body>
    <div class="container">
        <h3 style="color: #ff0000;"><?= isset($error) ? $error : "" ?></h3>
        <h2>Bill Information</h2>
        <div class="bill-info">
            <p><strong>Title:</strong> <?php echo htmlspecialchars($bill->getTitle()); ?></p>
            <p><strong>Description:</strong> <?php echo htmlspecialchars($bill->getDescription()); ?></p>
            <p><strong>Author:</strong> <?php echo htmlspecialchars($bill->getUsername()); ?></p> <!-- You may want to fetch username from user table -->
            <p><strong>Status:</strong> <?php echo htmlspecialchars($bill->getStatus()); ?></p>
            <p><strong>Created Time:</strong> <?php echo htmlspecialchars($bill->getCreatedTime()); ?></p>
            <p><strong>Updated Time:</strong> <?php echo htmlspecialchars($bill->getUpdatedTime()); ?></p>
        </div>
        <div class="section">
            <h3>Bill Amendments</h3>
            <div class="amendments-container">
                <?php if (!empty($amendments)): ?>
                    <?php foreach ($amendments as $amendment): ?>
                        <div class="amendment">
                            <p><strong>Amendment by:</strong> <?php echo htmlspecialchars($amendment->getAuthorName()); ?></p> <!-- Assuming getAuthorName() returns the name of the author -->
                            <p><strong>Date:</strong> <?php echo htmlspecialchars($amendment->getCreatedTime()); ?></p>
                            <p><strong>Amendment:</strong> <?php echo htmlspecialchars($amendment->getAmendmentContent()); ?></p>
                            <p><strong>Comment:</strong> <?php echo htmlspecialchars($amendment->getComment()); ?></p>
                        </div>
                        <hr style="border: 1px solid #ff0000;">
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>No amendments have been made for this bill.</p>
                <?php endif; ?>
            </div>
        </div>
        <div class="section">
            <h3>Add Amendment</h3>
            <form action="AddAmendment" method="POST">
                <label for="amendment">Your Amendment:</label>
                <textarea id="amendment" name="amendment" required></textarea>

                <h3>Add Comment</h3>
                <label for="comment">Your Comment:</label>
                <textarea id="comment" name="comment" required></textarea>

                <input type="hidden" name="billId" value="<?php echo htmlspecialchars($bill->getId()); ?>">
                <input type="submit" value="Submit Amendment and Comment">
            </form>
        </div>


    </div>
</body>

</html>