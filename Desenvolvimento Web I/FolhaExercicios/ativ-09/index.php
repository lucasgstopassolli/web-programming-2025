<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Folha de Exercícios</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>

   <form method="post">
        <h2>Simulador de Parcelas (Moto - Juros Compostos)</h2>
        <div class="block">
            <div class="fields">
                <label for="valor_moto">Valor da moto:</label>
                <input type="number" id="valor_moto" name="valor_moto" placeholder="Ex: 8654.00" value="8654" step="0.01" required><br>
            </div>
            <div class="fields">
                <label for="parcelas">Plano de Parcelamento:</label>
                <select id="parcelas" name="parcelas" required>
                    <option value="24">24 vezes (Taxa 2.0%)</option>
                    <option value="36">36 vezes (Taxa 2.3%)</option>
                    <option value="48">48 vezes (Taxa 2.6%)</option>
                    <option value="60">60 vezes (Taxa 2.9%)</option>
                </select><br>
            </div>
        </div>
        <button type="submit">Calcular Parcela</button>
    </form>

    <?php
    include 'resources/main.php';
    ?>
</body>

</html>