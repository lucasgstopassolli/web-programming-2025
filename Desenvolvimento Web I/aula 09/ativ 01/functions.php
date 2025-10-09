<?php
function calculateAverage($grds){
    $total = array_sum($grds);
    $count = count($grds);
    $average = $total / $count;
    return number_format($average, 2);
};


function calculateAproval($grds){
    $avrGrades = calculateAverage($grds);
    if ($avrGrades >= 7){
        echo "Aprovado";
    } else {
        echo "Reprovado";
    }
};

function calculateMisses($mss){
    $sm = 0;
    foreach ($mss  as $amss) $sm += $amss;
    return round($sm * 10 / count($mss));
}