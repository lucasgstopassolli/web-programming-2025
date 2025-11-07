<?php

    class Calculator {
        private $n1;
        private $n2;

        public function add() {
            return $this->n1 + $this->n2;
        }

        public function subtract() {
            return $this->n1 - $this->n2;
        }

        public function multiply() {
            return $this->n1 * $this->n2;
        }

        public function divide() {
            try {
                return $this->n1 / $this->n2;
            } catch (Exception $e) {
                echo 'Caught exception: ',  $e->getMessage(), "\n";
            }
        }

        public function setN1($n1) {
            $this->n1 = $n1;
        }
        public function setN2($n2) {
            $this->n2 = $n2;
        }
        public function getN1() {
            return $this->n1;
        }
        public function getN2() {
            return $this->n2;
        }
    }

?>