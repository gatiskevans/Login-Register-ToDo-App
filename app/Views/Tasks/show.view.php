<?php require_once 'app/Views/Partials/header.php'; ?>
<?php require_once 'app/Views/Partials/welcome.php'; ?>

<?php if(isset($_SESSION['user_name'])): ?>

    <div id="container">
        <div id="list">
            <h2>ToDo App</h2>
            <br>
            <table>
                <?php foreach ($tasks->getListOfTasks() as $task): ?>
                    <tbody>
                    <?php echo "<td> {$task->getTask()}</td>"; ?>
                    <?php echo "<td> <small>({$task->getTimeCreated()})</small></td>"; ?>
                    <?php echo "<td> {$task->getStatus()}</td>"; ?>
                    <td>
                        <form action="/todo/<?php echo $task->getId() ?>" method="post">
                            <button type="submit">X</button>
                        </form>
                    </td>
                    </tbody>
                <?php endforeach; ?>

                <?php if (count($tasks->getListOfTasks()) === 0)
                    echo "<td><b>There are no contents in ToDo list yet!</b></td>"; ?>
            </table>
        </div>

<?php endif; ?>

        <br><br>
        <?php require_once 'app/Views/Partials/menu.php';?>
    </div>

<?php require_once 'app/Views/Partials/footer.php'; ?>