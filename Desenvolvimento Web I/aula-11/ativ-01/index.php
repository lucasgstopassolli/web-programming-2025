<?php
    $dbconn = pg_connect("host=localhost port=5432 dbname=CleberClass user=postgres password=postgres");
    $busca = filter_input(INPUT_GET, 'busca', FILTER_SANITIZE_SPECIAL_CHARS);
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Lista de Pessoas</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="container">
        <h2>Lista de Pessoas</h2>

        <form method="GET">
            <input type="text" name="busca" placeholder="Buscar por nome..." value="<?= $busca ?>">
            <button type="submit">Pesquisar</button>
        </form>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Email</th>
                    <th>Cidade/UF</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($dbconn) {
                    if ($busca) {
                        $sql = "SELECT * FROM TBPESSOA WHERE PESNOME ILIKE $1";
                        $result = pg_query_params($dbconn, $sql, array('%' . $busca . '%'));
                    } else {
                        $sql = "SELECT * FROM TBPESSOA";
                        $result = pg_query($dbconn, $sql);
                    }

                    if (pg_num_rows($result) > 0) {
                        while ($row = pg_fetch_assoc($result)) {
                            echo "<tr>";
                            echo "<td>" . $row['pescodigo'] . "</td>";
                            echo "<td>" . $row['pesnome'] . " " . $row['pessobrenome'] . "</td>";
                            echo "<td>" . $row['pesemail'] . "</td>";
                            echo "<td>" . $row['pescidade'] . "/" . $row['pesestado'] . "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='4' style='text-align:center'>Nenhum registro encontrado.</td></tr>";
                    }
                }
                ?>
            </tbody>
        </table>

        <div style="text-align: center; margin-top: 20px;">
            <a href="https://www.youtube.com/watch?v=2qBlE2-WL60" style="text-decoration: none; color: #5563de; font-weight: bold;" target="_blank">+ Cadastrar Nova Pessoa</a>
        </div>
    </div>
</body>

</html>