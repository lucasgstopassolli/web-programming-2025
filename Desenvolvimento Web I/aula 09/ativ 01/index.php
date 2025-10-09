<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Atividade 01</title>
    <?php require_once("functions.php");?>
</head>
<body>
    
    <?php
        $grades = array(7.5, 8.0, 9.0, 6.5, 7.0, 8, 9.4, 10);
        $misses = array(false, false, true, true, true, true);
        

        $sm = calculateAverage($grades);
        echo "A média das notas é igual a: $sm <br>";

        echo "Pelas notas, o aluno foi: ";
        calculateAproval($grades);
        
        echo "<br>";
        $missesLog = calculateMisses($misses);
        
        echo"$missesLog";
        echo "<br>";

        if ($missesLog >= 7) {
            echo "Aluno aprovado por frequência";
        } else {
            echo "Aluno reprovou por faltas";
        }
    ?>

</body>
</html>