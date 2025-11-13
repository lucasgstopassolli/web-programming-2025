<?php

// Inclui as configurações da aplicação.
require_once '../config.php';

// Renderiza o cabeçalho padrão da página HTML.
function render_header($pageTitle = APP_NAME)
{
    $title = htmlspecialchars($pageTitle);

    echo <<<HTML
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{$title}</title>
    
    <!-- Bibliotecas CSS -->
    <link rel="stylesheet" href="css/library/bootstrap.min.css">
    <link rel="stylesheet" href="css/library/splide.min.css">
    
    <!-- Estilos personalizados -->
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
<div class="container mt-4">
HTML;
}

// Renderiza o rodapé padrão da página HTML.
function render_footer($showAnonymityNotice = false)
{
    echo '</div>'; // Fecha o .container principal

    if ($showAnonymityNotice) {
        echo <<<HTML
<footer class="text-center text-muted mt-5 mb-3">
    <p class="small">Sua avaliação espontânea é anônima, nenhuma informação pessoal é solicitada ou armazenada.</p>
</footer>
HTML;
    }

    echo <<<HTML
<!-- Bibliotecas JS -->
<script src="js/library/bootstrap.bundle.min.js"></script>
<script src="js/library/splide.min.js"></script>

<!-- Scripts personalizados -->
<script src="js/scripts.js"></script>

</body>
</html>
HTML;
}