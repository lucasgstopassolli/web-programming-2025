<?php
// Carregamento manual das classes
require_once "app/model/Endereco.php";
require_once "app/model/Contato.php";
require_once "app/model/Pessoa.php";

use app\model\Pessoa;
use app\model\Endereco;
use app\model\Contato;

/* --- EXERCÍCIO 1: Instanciar VOCÊ --- [cite: 455] */
$eu = new Pessoa("SeuNome", "SeuSobrenome");
$eu->setEndereco(new Endereco("Rua X", "Centro", "Rio do Sul", "SC", "89160-000"));
$eu->addContato(new Contato(1, "Celular", "47 9999-9999"));

/* --- EXERCÍCIO 2: Família e Arquivo TXT --- [cite: 484-486] */
$familia = [];
$familia[] = $eu;

// Criando pai
$pai = new Pessoa("Pai", "Sobrenome");
$pai->setEndereco(new Endereco("Rua Y", "Bairro", "Cidade", "SC", "00000-000"));
$familia[] = $pai;

// Criando mãe
$mae = new Pessoa("Mãe", "Sobrenome");
$familia[] = $mae;

// Salvando em TXT (Serializado)
$dadosSerializados = serialize($familia);
file_put_contents("familia.txt", $dadosSerializados);

/* --- EXERCÍCIO 3: JSON --- [cite: 495] */

$jsonFinal = "[";
$listaJson = [];
foreach ($familia as $membro) {
    // Usa o método toJson implementado na classe
    $listaJson[] = $membro->toJson();
}
// Monta o JSON array manualmente pois o método retorna string json individual
$arquivoJson = "[" . implode(",", $listaJson) . "]";

file_put_contents("familia.json", $arquivoJson);

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Exercícios</title>
</head>
<body>
    <div class="container">
        <h2>Exercício 2 - Arquivo TXT Gerado</h2>
        <p>Verifique o arquivo <strong>familia.txt</strong> na pasta.</p>
        <p>Conteúdo Serializado:</p>
        <pre><?= $dadosSerializados ?></pre>
    </div>

    <div class="container">
        <h2>Exercício 3 - Arquivo JSON Gerado</h2>
        <p>Verifique o arquivo <strong>familia.json</strong> na pasta.</p>
        <p>Conteúdo JSON:</p>
        <pre><?= $arquivoJson ?></pre>
    </div>
</body>
</html>