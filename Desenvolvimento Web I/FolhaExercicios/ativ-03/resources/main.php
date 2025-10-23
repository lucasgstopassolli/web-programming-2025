<?php

include 'functions.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $v1 = $_POST["v1"];

    $result = calculateArea($v1);

    echo "<div class='result'>A área do quadrado de lado $v1 é $result metros quadrados</div>";

}