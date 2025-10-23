<?php

include 'functions.php';

$dinheiro_disponivel = 50.0;
$total_gasto = 0.0;

$produtos_precos = [
    "maca" => 5.00,
    "melancia" => 2.00,
    "laranja" => 3.00,
    "repolho" => 2.00,
    "cenoura" => 5.00,
    "batatinha" => 5.00
];


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    foreach ($produtos_precos as $produto_nome => $preco_kg) {
        
        $quantidade = $_POST[$produto_nome];
        
        $total_gasto += $preco_kg * $quantidade;
    }

    echo "<p>O valor total da compra foi: R$ $total_gasto.</p>";

    $saldo = $dinheiro_disponivel - $total_gasto;
    $saldo_formatado = number_format(abs($saldo));

    if ($saldo < 0) {
        echo "<p style='color: red;'>O dinheiro não foi suficiente. Ficou R$ $saldo_formatado acima do disponível.</p>";
    } elseif ($saldo > 0) {
        echo "<p style='color: blue;'>O dinheiro foi suficiente. Joãozinho ainda pode gastar R$ $saldo_formatado.</p>";
    } else {
        echo "<p style='color: green;'>O saldo para compras foi esgotado. O valor da compra foi exatamente R$ 50,00.</p>";
    }

}

?>