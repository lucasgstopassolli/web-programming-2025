<?php


class computer {
    private $estado;
    public function ligar() {
        if ($this->estado == "ligado") {
            return false;
        }
        $this->estado = "ligado";
        return true;
    }

    public function desligar() {
        if ($this->estado == "desligado") {
            return false;
        }
        $this->estado = "desligado";
        return true;
    }

    public function getEstado() {
        return $this->estado;
    } 

}