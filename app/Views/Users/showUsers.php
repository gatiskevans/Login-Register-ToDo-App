<?php require_once 'app/Views/Partials/header.php'; ?>
<?php require_once 'app/Views/Partials/welcome.php'; ?>

    <?php foreach($users->getAllUsers() as $user): ?>

        <?php echo "<ul>Name: <b>{$user->getName()}</b>"; ?>
        <?php echo "(id:<small>{$user->getId()}</small>)</ul>"; ?>

    <?php endforeach; ?>

    <br>
    <a href="/todo">Back to Task List</a>

<?php require_once 'app/Views/Partials/footer.php'; ?>
