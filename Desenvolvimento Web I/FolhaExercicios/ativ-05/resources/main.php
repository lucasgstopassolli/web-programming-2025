<?php

include 'functions.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $base = $_POST["base"];
    $altura = $_POST["altura"];

    $area = areaTrianguloRetangulo($base, $altura);

    $frase = "A área do triângulo retângulo de base $base metros e<br>altura $altura metros é $area metros quadrados.";

    echo "<div class='result'>$frase</div>";
}