<?php

if(!isset($_SESSION['user_name'])){
    header('Location: /loginView');
}

require_once 'app/Views/Partials/header.php';
require_once 'app/Views/Partials/welcome.php';

?>

    <h2>Login Successful!</h2>
    <form action="/" method="get">
        <button value="OK">OK</button>
    </form>

<?php

require_once 'app/Views/Partials/footer.php';