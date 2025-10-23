<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Folha de Exercícios</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    
    <form method="post">
        <h2>Divisivel por 2?</h2>
        <div class="block">
            <input type="number" name="v1" placeholder="Valor a ser verificado" required><br>
        </div>
        <button type="submit">Verificar</button>
    </form>

    <?php
    include 'resources/main.php';
    ?>
</body>

</html>