<?php

if(isset($_SESSION['user_name'])){
    echo "Welcome, {$_SESSION['user_name']}! ";
    echo "<a href='/logout'>Logout</a><br>";
} else {
    echo "Welcome, guest! ";
    echo "<a href='/login'>Login</a><br>";
}

