<?php
namespace app\model;

class Contato {
    private $id;
    private $tipo;
    private $descricao;

    public function __construct($id, $tipo, $descricao) {
        $this->id = $id;
        $this->tipo = $tipo;
        $this->descricao = $descricao;
    }

    public function toArray() {
        return [
            'id' => $this->id,
            'tipo' => $this->tipo,
            'descricao' => $this->descricao,
        ];
    }
}
?>