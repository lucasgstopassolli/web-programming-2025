<?php

$salario1 = 1000;
$salario2 = 2000;
$salario2 = $salario1;
++$salario2;
$salario1 *= 1.1;

for ($i = 1; $i <= 100; $i++) {
    $salario1++;
    if ($i == 50) {
        break;
    }
}

if ($salario1 < $salario2) {
    echo $salario1;
}

?>
