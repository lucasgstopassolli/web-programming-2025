<?php

include 'resources/functions.php';

$pastas = [
    "bsn" => [
        "3a Fase" => [
            "desenvWeb",
            "bancoDados 1",
            "engSoft 1"
        ],
        "4a Fase" => [
            "Intro Web",
            "bancoDados 2",
            "engSoft 2"
        ]
    ]
];


echo "<div class='result' style='font-family: monospace; line-height: 1.6;'>";
exibirPastasRecursivamente($pastas);
echo "</div>";
