<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Folha de Exercícios</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    
    <form method="post">
        <h2>Soma de Três Valores</h2>
        <div class="block">
            <input type="number" name="v1" placeholder="Valor 1" required><br>
            <input type="number" name="v2" placeholder="Valor 2" required><br>
            <input type="number" name="v3" placeholder="Valor 3" required><br>
        </div>
        <button type="submit">Calcular</button>
    </form>

    <?php
    include 'resources/main.php';
    ?>
</body>

</html>