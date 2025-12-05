<?php
namespace app\model;

class Pessoa {
    // Atributos conforme Slide 22 [cite: 296]
    private $nome;
    private $sobrenome;
    private $dataNascimento;
    private $cpfCnpj;
    private $tipo;
    
    // Relacionamentos [cite: 304, 303]
    private $endereco; // Objeto Endereco
    private $contatos = []; // Array de objetos Contato (0..*)

    public function __construct($nome, $sobrenome, $cpfCnpj = null) {
        $this->nome = $nome;
        $this->sobrenome = $sobrenome;
        $this->cpfCnpj = $cpfCnpj;
    }

    // Setters para relacionamentos
    public function setEndereco(Endereco $endereco) {
        $this->endereco = $endereco;
    }

    public function addContato(Contato $contato) {
        $this->contatos[] = $contato;
    }

    public function getNomeCompleto() {
        return $this->nome . " " . $this->sobrenome;
    }

    // Implementação do Exercicio 3: Método toJson [cite: 327]
    public function toJson() {
        // get_object_vars pega atributos privados dentro da classe
        $vars = get_object_vars($this);
        
        // Conversão manual dos objetos internos para array para o JSON ficar limpo
        if($this->endereco) {
            $vars['endereco'] = $this->endereco->toArray();
        }
        
        $vars['contatos'] = array_map(function($c) { return $c->toArray(); }, $this->contatos);

        return json_encode($vars, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }
    
    // Método mágico toString (Slide 15) útil para salvar em TXT
    public function __toString() {
        return "Nome: " . $this->getNomeCompleto() . " | CPF: " . $this->cpfCnpj;
    }
}
?>