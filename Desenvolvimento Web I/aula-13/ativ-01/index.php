<?php
// Requere as classes
require_once "app/model/Endereco.php";
require_once "app/model/Contato.php";
require_once "app/model/Pessoa.php";

use app\model\Pessoa;
use app\model\Endereco;
use app\model\Contato;

// --- Exercicio 1: Instanciar VOCÊ [cite: 290] ---
$eu = new Pessoa("SeuNome", "Sobrenome", "123.456.789-00");
$eu->setEndereco(new Endereco("Rua X", "Centro", "Rio do Sul", "SC", "89160-000"));
$eu->addContato(new Contato(1, "Celular", "(47) 99999-9999"));

echo "<h1>Exercícios de Orientação a Objetos</h1>";
echo "<p>Abra o arquivo `executar_exercicios.php` para ver os resultados.</p>";

?>