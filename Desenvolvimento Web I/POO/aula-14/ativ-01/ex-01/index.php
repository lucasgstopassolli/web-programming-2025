<?php

    require_once "calculator.php";

    $calulator = new Calculator();
    $calulator->setN1(10);
    $calulator->setN2(2);

    echo "Sum: ".$calulator->add()."<br>";
?>