<?php
try {
    $valor = $_REQUEST["valor"];
    $desconto = $_REQUEST["desconto"];

    if (!is_numeric($valor) || !is_numeric($desconto)) {
        throw new Exception("Valor e desconto devem ser números.");
    }

    function calcular($value, $discount) {
        return $value - ($value * ($discount / 100));
    }

    $resultado = calcular($valor, $desconto);

    echo "Valor original: R$ $valor<br>";
    echo "Desconto: $desconto%<br>";
    echo "Valor final: R$ $resultado";

} catch (Exception $e) {
    echo "Erro: " . $e->getMessage();
}
?>
