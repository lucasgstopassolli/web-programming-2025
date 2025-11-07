<?php

    class team{
        private $name;
        private $foundationYear;
        private $players;

        public function __construct(){
            $this->players = array();
        }

        public function addPlayer($name, $position, $bornDate){
            $player = new Player();
            $player->setName($name);
            $player->setPosition($position);
            $player->setBornDate(new DateTime($bornDate));

            array_push($this->players, $player);
        }

        public function getName(){
            return $this->name;
        }
        public function setName($name){
            $this->name = $name;
        }
        public function getFoundationYear(){
            return $this->foundationYear;
        }
        public function setFoundationYear($foundationYear){
            $this->foundationYear = $foundationYear;
        }
        public function getPlayers(){
            return $this->players;
        }
        public function setPlayers($players){
            $this->players = $players;
        }
    }