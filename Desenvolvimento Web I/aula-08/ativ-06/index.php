<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Atividade 06</title>
</head>

<body>

    <table>
        <th>Disciplina</th>
        <th>Faltas</th>
        <th>Média</th>

        <?php

        $boletim = array(
            array("Disciplina" => "Matemática", "Faltas" => 5, "Média" => 7.5),
            array("Disciplina" => "Português", "Faltas" => 2, "Média" => 8.0),
            array("Disciplina" => "História", "Faltas" => 0, "Média" => 9.0),
            array("Disciplina" => "Geografia", "Faltas" => 1, "Média" => 6.5),
            array("Disciplina" => "Ciências", "Faltas" => 3, "Média" => 7.0),
            array("Disciplina" => "Inglês", "Faltas" => 4, "Média" => 8.5)
        );

        foreach($boletim as $b){
            echo"<tr>
                <td>" . $b['Disciplina'] . "</td>
                <td>" . $b['Faltas'] . "</td>
                <td>" . $b['Média'] . "</td>
            </tr>";
        };



        ?>
    </table>

</body>

</html>