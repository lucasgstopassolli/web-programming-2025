<?php
namespace app\model;

class Endereco {
    // Atributos conforme Slide 21 [cite: 278]
    private $logradouro;
    private $bairro;
    private $cidade;
    private $estado;
    private $cep;

    public function __construct($logradouro, $bairro, $cidade, $estado, $cep) {
        $this->logradouro = $logradouro;
        $this->bairro = $bairro;
        $this->cidade = $cidade;
        $this->estado = $estado;
        $this->cep = $cep;
    }

    // Método auxiliar para transformar objeto em array (para o JSON funcionar bem)
    public function toArray() {
        return get_object_vars($this);
    }
}
?>