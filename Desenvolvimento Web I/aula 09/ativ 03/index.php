<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Atividade 03</title>
    <?php require_once("functions.php");?>
</head>
<body>
    
    <h2>Calcular Valor com Desconto</h2>

    <form method="get" action="">
        Valor: <input type="number" name="valor" step="0.01" required><br><br>
        Desconto (%): <input type="number" name="desconto" step="0.01" required><br><br>
        <input type="submit" value="Calcular">
    </form>

    <hr>

</body>
</html>