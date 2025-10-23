<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Folha de Exercícios</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>

    <form method="post">
        <h2>Informe os valores gastos</h2>
        <div class="block">
            <div class="fields">
                <label for="maca">Maçã: <span style="color: #7c7c7cff">(R$5,00/kg)</span></label>
                <input type="number" name="maca" placeholder="Valor gasto" required>
            </div>
            <div class="fields">
                <label for="melancia">Melancia: <span style="color: #7c7c7cff">(R$2,00/kg)</span></label>
                <input type="number" name="melancia" placeholder="Valor gasto" required>
            </div>
            <div class="fields">
                <label for="laranja">Laranja: <span style="color: #7c7c7cff">(R$3,00/kg)</span></label>
                <input type="number" name="laranja" placeholder="Valor gasto" required>
            </div>
            <div class="fields">
                <label for="repolho">Repolho: <span style="color: #7c7c7cff">(R$2,00/kg)</span></label>
                <input type="number" name="repolho" placeholder="Valor gasto" required>
            </div>
            <div class="fields">
                <label for="cenoura">Cenoura: <span style="color: #7c7c7cff">(R$5,00/kg)</span></label>
                <input type="number" name="cenoura" placeholder="Valor gasto" required>
            </div>
            <div class="fields">
                <label for="batatinha">Batatinha: <span style="color: #7c7c7cff">(R$5,00/kg)</span></label>
                <input type="number" name="batatinha" placeholder="Valor gasto" required>
            </div>
        </div>
        <button type="submit">Verificar</button>
    </form>

    <?php
    include 'resources/main.php';
    ?>
</body>

</html>