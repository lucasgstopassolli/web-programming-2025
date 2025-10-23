<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Folha de Exercícios</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>

    <form method="post">
        <h2>Valores do financiamento</h2>
        <div class="block">
            <div class="fields">
                <label for="value">Valor do carro:</label>
                <input type="number" name="value" placeholder="Valor 1" value="22500" required><br>
            </div>
            <div class="fields">
                <label for="parcela">Parcelas:</label>
                <input type="number" name="parcela" placeholder="Valor 2" value="60" required><br>
            </div>
            <div class="fields">
                <label for="value_parcela">Valor da parcela:</label>
                <input type="number" name="value_parcela" placeholder="Valor 3" value="489.65" required><br>
            </div>
        </div>
        <!-- <button type="submit">Verificar</button> -->
    </form>

    <?php
    include 'resources/main.php';
    ?>
</body>

</html>