<?php

include 'functions.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $v1 = $_POST["v1"];
    $v2 = $_POST["v2"];

    $area = calcularAreaRetangulo($v1, $v2);

    $frase = "A área do retângulo de lados $v1 e $v2 metros é $area metros quadrados.";

    if ($area > 10) {
        echo "<h1>$frase</h1>";
    } else {
        echo "<h3>$frase</h3>";
    }
}