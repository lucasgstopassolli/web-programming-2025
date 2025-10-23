<?php


function getTaxaJurosSimples($meses) {
    $taxas_map = [
        24 => 0.015,
        36 => 0.020,
        48 => 0.025,
        60 => 0.030
    ];

    return $taxas_map[$meses];
}

function calcularMontanteJurosSimples($capital, $taxa, $tempo) {
    return $capital * (1 + $taxa * $tempo);
}

function calcularValorParcela($montante, $tempo) {
    return $montante / $tempo;
}

?>