<?php

if(isset($_SESSION['user_name'])): ?>
<div>
    <br>
    <a href="/add">Add Task</a><br>
    <a href="/users">View Registered Users</a><br>
</div>

<?php endif; ?>

<div>
    <a href="/register">Register User</a><br>
</div>