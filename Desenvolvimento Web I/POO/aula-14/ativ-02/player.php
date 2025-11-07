<?php

    class Player{
        private $name;
        private $position;
        private $bornDate;

        public function getName(){
            return $this->name;
        }
        public function setName($name){
            $this->name = $name;
        }
        public function getPosition(){
            return $this->position;
        }
        public function setPosition($position){
            $this->position = $position;
        }
        public function getBornDate(){
            return $this->bornDate;
        }
        public function setBornDate($bornDate){
            $this->bornDate = $bornDate;
        }
    }

?>