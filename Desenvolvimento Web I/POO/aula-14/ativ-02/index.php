<?php

    require_once 'team.php';
    require_once 'player.php';

    $team = new team();
    $team->setName("Dream FC");
    $team->setFoundationYear(1990);

    $team->addPlayer("Alice", "Forward", "1995-04-12");
    $team->addPlayer("Bob", "Midfielder", "1993-08-23");
    $team->addPlayer("Charlie", "Defender", "1992-11-05");

    echo "Team: " . $team->getName() . "\n";
    echo "Foundation Year: " . $team->getFoundationYear() . "\n";
    echo "Players:\n";

    foreach($team->getPlayers() as $player){
        echo "<br>" . "Name: " . $player->getName() . "<br>" . "Position: " . $player->getPosition() . "<br>".
        "Born Date: " . $player->getBornDate()->format('Y-m-d') . "\n";
    }


?>