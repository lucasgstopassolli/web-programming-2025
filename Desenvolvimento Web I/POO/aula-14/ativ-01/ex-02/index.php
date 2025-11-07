<?php

    require_once "computer.php";

    $computador = new computer();

    if ($computador->ligar()) {
        echo "Computador ligado com sucesso!<br>";
    } else {
        echo "O computador já está ligado!<br>";
    }
?>