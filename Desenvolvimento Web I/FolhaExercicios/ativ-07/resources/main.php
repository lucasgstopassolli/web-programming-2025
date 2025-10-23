<?php

$valor_a_vista = 22500.00;
$numero_parcelas = 60;
$valor_parcela = 489.65;

$valor_total_financiado = $numero_parcelas * $valor_parcela;

$juros_pagos = $valor_total_financiado - $valor_a_vista;

$juros_formatados = number_format($juros_pagos);

echo "<p>O valor total pago apenas em juros por Mariazinha será de R$ $juros_formatados.</p>";

?>