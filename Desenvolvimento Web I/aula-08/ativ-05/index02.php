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

// array associativo dos professores e materias
$professoresMaterias = array(
    "Cleber" => "Progr Web I",
    "Marco" => "Banco de Dados II",
    "Julian" => "Engenharia de Software",
    "Marciel" => "Administração e Sistemas de Informação",
    "Fernando" => "Estrutura de Dados"
);

foreach ($professoresMaterias as $professor => $materia) {
    echo "O professor " . $professor . ", Professor: " . $materia . ".<br>";
}

?>