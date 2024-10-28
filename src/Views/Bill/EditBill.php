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

        .amendment-container {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            justify-content: space-between;
        }

        .amendment-item {
            flex: 1 1 30%;
            max-width: 30%;
            background-color: #fff0f0;
            border: 1px solid #d32f2f;
            color: #333;
            font-weight: normal;
            padding: 15px;
            line-height: 1.6;
            border-radius: 5px;
        }

        button {
            background-color: #d32f2f;
            color: #ffffff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
        }

        button:hover {
            background-color: #b71c1c;
        }

        input[type="text"],
        textarea {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 5px;
            margin-bottom: 10px;
            font-size: 14px;
        }
    </style>
</head>

<body>
    <div class="container">
        <!-- Bill Information Editable Form -->
        <?php if (isset($_SESSION["Role"]) && $_SESSION["Role"] === "MP") : ?>
            <form method="POST" action="UpdateBill">
                <div class="section">
                    <h2>Edit Bill Information</h2>
                    <div class="content-box">
                        <label for="title"><strong>Title:</strong></label>
                        <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($bill->getTitle()); ?>">

                        <label for="description"><strong>Description:</strong></label>
                        <textarea id="description" name="description" rows="4"><?php echo htmlspecialchars($bill->getDescription()); ?></textarea>

                        <label for="draft_content"><strong>Draft Content:</strong></label>
                        <textarea id="draft_content" name="draft_content" rows="6"><?php echo htmlspecialchars($bill->getDraftContent()); ?></textarea>

                        <input type="text" id=billId name="billId" hidden value="<?php echo htmlspecialchars($bill->getId()); ?>">
                        <button type="submit">Save Changes</button>
                    </div>
                </div>
            </form>
        <?php else : ?>
            <div class="section">
                <h2>Bill Information</h2>
                <div class="content-box">
                    <p><strong>Title:</strong> <?php echo htmlspecialchars($bill->getTitle()); ?></p>
                    <p><strong>Description:</strong> <?php echo htmlspecialchars($bill->getDescription()); ?></p>
                    <p><strong>Draft Content:</strong> <?php echo htmlspecialchars($bill->getDraftContent()); ?></p>
                </div>
            </div>
        <?php endif; ?>

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
</body>

</html>