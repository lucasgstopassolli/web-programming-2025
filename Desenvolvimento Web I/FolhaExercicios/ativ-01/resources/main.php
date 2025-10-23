<?php

include 'functions.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $v1 = $_POST["v1"];
    $v2 = $_POST["v2"];
    $v3 = $_POST["v3"];

    $colorClass = "";

    $result = sumValues($v1, $v2, $v3);

    if($v3 < $v1 && $v3 < $v2) {
        $colorClass = "font-red";
    } elseif ($v1 > 10) {
        $colorClass = "font-blue";
    } elseif ($v2 < $v3) {
        $colorClass = "font-green";
    }

    echo "<div class='result $colorClass'>Resultado: $result</div>";
}
