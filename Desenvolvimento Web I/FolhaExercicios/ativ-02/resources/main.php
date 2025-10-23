<?php

include 'functions.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $v1 = $_POST["v1"];

    $result = verifyNum($v1);

    echo "<div class='result'>Resultado: $result</div>";
}
