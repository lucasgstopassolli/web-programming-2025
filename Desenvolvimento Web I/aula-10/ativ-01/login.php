<?php

    session_start();

    if(!isset($_SESSION['username'])) {
        $_SESSION['username'] = $_POST['username'];
        $_SESSION['password'] = $_POST['password'];
        $_SESSION['session_start'] = date("d/m/Y H:i:s");
        $_SESSION['last_access'] = $_SESSION['session_start'];

        echo "Session started successfully";
        $sessionTime = 0;
    } else {
        $_SESSION['last_access'] = date("d/m/Y H:i:s");

        echo "User: " . $_SESSION['username'] . " is logged<br>";
        echo "Password: " . $_SESSION['password'] . "<br><br>";
        echo "Session started at: " . $_SESSION['session_start'] . "<br>";
        echo "Last access at: " . $_SESSION['last_access'] . "<br>";

        $sessionTime = strtotime($_SESSION['last_access']) - strtotime($_SESSION['session_start']);

        echo "Time since session started: " . $sessionTime . " seconds<br>";
    }
    
    if($sessionTime > 60) {
        session_unset();
        session_destroy();
        echo "Session expired. Please log in again.";
    }