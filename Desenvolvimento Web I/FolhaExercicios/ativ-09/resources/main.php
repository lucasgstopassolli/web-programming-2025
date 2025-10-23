<?php

include 'resources/functions.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $capital = $_POST['valor_moto'];
    $meses = $_POST['parcelas'];

    $taxa_decimal = getTaxaJurosCompostos($meses);
    
    if ($taxa_decimal !== null && $capital > 0) {
        
        $montante = calcularMontanteJurosCompostos($capital, $taxa_decimal, $meses);
        $valor_parcela = calcularValorParcela($montante, $meses);

        $taxa_percentual = $taxa_decimal * 100;
        $parcela_formatada = number_format($valor_parcela, 2, ',', '.');
        $montante_formatado = number_format($montante, 2, ',', '.');
        
        echo "<div class='result'>";
        echo "Para $meses meses (taxa $taxa_percentual% a.m.), a parcela será de R$ $parcela_formatada.<br>";
        echo "(Valor total pago: R$ $montante_formatado)";
        echo "</div>";

    }
}

?>