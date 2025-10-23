<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Atividade 01</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

    <div class="container">
        <h2>Cadastro de Cliente</h2>
        <form action="db.php" method="POST">
            <label for="pesnome">Nome</label>
            <input type="text" id="pesnome" name="pesnome" required>

            <label for="pessobrenome">Sobrenome</label>
            <input type="text" id="pessobrenome" name="pessobrenome" required>

            <label for="pesemail">E-mail</label>
            <input type="email" id="pesemail" name="pesemail" required>

            <label for="pespassword">Senha</label>
            <input type="password" id="pespassword" name="pespassword" required>

            <label for="pescidade">Cidade</label>
            <input type="text" id="pescidade" name="pescidade" required>

            <label for="pesestado">Estado</label>
            <select id="pesestado" name="pesestado" required>
                <option value="">Selecione...</option>
                <option>SP</option>
                <option>RJ</option>
                <option>MG</option>
                <option>RS</option>
                <option>PR</option>
                <option>SC</option>
                <option>BA</option>
                <option>PE</option>
                <option>CE</option>
                <option>GO</option>
            </select>

            <button type="submit">Cadastrar</button>
        </form>

        <?php include 'printContent.php'; ?>
    </div>


</body>

</html>