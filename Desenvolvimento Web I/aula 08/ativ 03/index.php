<?php

$salario1 = 1000;
$salario2 = 2000;
$salario2 = $salario1;
++$salario2;
$salario1 *= 1.1;

if ($salario1 > $salario2) {
    echo "O Valor da variável 1 é maior que o valor da variável 2";
} elseif ($salario1 < $salario2) {
    echo "O Valor da variável 1 é menor que o valor da variável 2";
} else {
    echo "Os valores são iguais";
}

?>
