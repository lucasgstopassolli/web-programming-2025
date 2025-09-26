<?php

$disciplinas = array(
    "Progr Web I",
    "Banco de Dados II",
    "Engenharia de Software",
    "Administração e Sistemas de Informação",
    "Estrutura de Dados"
);
$professores = array(
    "Cleber",
    "Marco",
    "Julian",
    "Marciel",
    "Fernando",
);

for ($i = 0; $i < count($disciplinas); $i++) {
    echo "A disciplina " . $disciplinas[$i] . ", Professor: " . $professores[$i] . ".<br>";
}

?>