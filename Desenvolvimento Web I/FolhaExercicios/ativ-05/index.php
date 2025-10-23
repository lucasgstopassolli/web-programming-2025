<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Folha de Exercícios</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    
    <form method="post">
        <h2>Informe o valor dos lados do triângulo retângulo</h2>
        <div class="block">
            <input type="number" name="base" placeholder="Valor 1" required><br>
            <input type="number" name="altura" placeholder="Valor 2" required><br>
            </div>
        <button type="submit">Verificar</button>
    </form>

    <?php
    include 'resources/main.php';
    ?>
</body>

</html>