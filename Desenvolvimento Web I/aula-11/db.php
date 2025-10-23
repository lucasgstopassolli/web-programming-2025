<?php

include 'db_connection.php';

if ($connection) {

    $dataRecived = array(
        'pesnome' => $_POST['pesnome'],
        'pessobrenome' => $_POST['pessobrenome'],
        'pesemail' => $_POST['pesemail'],
        'pespassword' => $_POST['pespassword'],
        'pescidade' => $_POST['pescidade'],
        'pesestado' => $_POST['pesestado']
    );
    
    $commandLine = 'INSERT INTO tbpessoa (pesnome, pessobrenome, pesemail, pespassword, pescidade, pesestado) VALUES ($1, $2, $3, $4, $5, $6)';

    $resultInsert = pg_query_params($connection, $commandLine, array_values($dataRecived));

    if ($resultInsert) {
        echo '<h2>Cadastro realizado com sucesso!</h2>';
    } else {
        echo '<h2>Erro ao realizar o cadastro:</h2>';
        echo pg_last_error($connection);
    }

    echo '<a href="index.php">Voltar para o Formulário</a>';

} else {
    echo "Erro ao conectar com o banco de dados: " . pg_last_error();
}

?>