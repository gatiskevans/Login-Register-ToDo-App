<?php

if(isset($_SESSION['id'])){
    echo "Welcome, {$_SESSION['id']}! ";
    echo "<a href='/logout'>Logout</a><br>";
} else {
    echo "Welcome, guest! ";
    echo "<a href='/login'>Login</a><br>";
}

