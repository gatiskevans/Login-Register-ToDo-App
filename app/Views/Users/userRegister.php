<?php require_once 'app/Views/Partials/header.php'; ?>
<h1>Registration Form</h1>
<form action="/confirmation" method="post">
    <label for="username">Enter Your name: </label><br>
    <input type="text" id="username" name="username" /><br>
    <label for="password">Choose Password: </label><br>
    <input type="password" id="password" name="password" /><br>
    <label for="passwordVerify">Enter Your Password Again: </label><br>
    <input type="password" id="passwordVerify" name="passwordVerify" /><br><br>
    <input type="submit" name="register" value="Register" />
</form>

<br>
<a href="/todo">Back to Task List</a>

<?php require_once 'app/Views/Partials/footer.php'; ?>