<?php

function exibirPastasRecursivamente($array, $prefixo = "- ") {
    foreach ($array as $chave => $valor) {
        if (is_array($valor)) {
            echo $prefixo . $chave . "<br>";
            exibirPastasRecursivamente($valor, $prefixo . "- ");
        } else {
            echo $prefixo . $valor . "<br>";
        }
    }
}

?>