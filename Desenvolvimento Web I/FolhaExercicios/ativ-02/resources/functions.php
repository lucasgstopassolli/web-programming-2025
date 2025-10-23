<?php

function verifyNum($a) {
    if ($a % 2 == 0) {
        return "$a é divisível por 2.";
    } else {
        return "$a não é divisível por 2.";
    }
}