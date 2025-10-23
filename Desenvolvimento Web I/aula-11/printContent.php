<?php

include 'db_connection.php';

echo '<h2>Usuários Cadastrados no Banco de Dados</h2>';

$selectQuery = 'SELECT * FROM tbpessoa ORDER BY pesnome';

$resultSelect = pg_query($connection, $selectQuery);

if ($resultSelect && pg_num_rows($resultSelect) > 0) {

    echo '<table border="1" style="width:100%; border-collapse: collapse;">';

    echo '<thead>';
    echo '<tr style="background-color: #f2f2f2;">';
    echo '<th>Nome</th>';
    echo '<th>Sobrenome</th>';
    echo '<th>Email</th>';
    echo '<th>Cidade</th>';
    echo '<th>Estado</th>';
    echo '</tr>';
    echo '</thead>';

    echo '<tbody>';

    while ($pessoa = pg_fetch_assoc($resultSelect)) {
        echo '<tr>';
        echo '<td>' . htmlspecialchars($pessoa['pesnome']) . '</td>';
        echo '<td>' . htmlspecialchars($pessoa['pessobrenome']) . '</td>';
        echo '<td>' . htmlspecialchars($pessoa['pesemail']) . '</td>';
        echo '<td>' . htmlspecialchars($pessoa['pescidade']) . '</td>';
        echo '<td>' . htmlspecialchars($pessoa['pesestado']) . '</td>';
        echo '</tr>';
    }

    echo '</tbody>';
    echo '</table>';

} else {
    echo 'Nenhum usuário cadastrado ainda.';
}
