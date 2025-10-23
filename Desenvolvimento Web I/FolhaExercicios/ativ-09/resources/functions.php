<?php

function getTaxaJurosCompostos($meses) {
    $taxas_map = [
        24 => 0.020,
        36 => 0.023,
        48 => 0.026,
        60 => 0.029
    ];

    return $taxas_map[$meses];
}

function calcularMontanteJurosCompostos($capital, $taxa, $tempo) {
    return $capital * ((1 + $taxa) ** $tempo);
}

function calcularValorParcela($montante, $tempo) {
    return $montante / $tempo;
}

?>