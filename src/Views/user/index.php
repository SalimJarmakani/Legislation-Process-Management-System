<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>User List</title>
</head>

<body>
    <h1>Hello This is The User List</h1>
    <ul>
        <?php foreach ($users as $user): ?>
            <li><?= $user->name ?> (<?= $user->email ?>)</li>
        <?php endforeach; ?>
    </ul>
</body>

</html>