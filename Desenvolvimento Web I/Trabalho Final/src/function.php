<?php

require_once '../config.php';

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
    <link rel="stylesheet" href="css/library/bootstrap.min.css">
    <link rel="stylesheet" href="css/library/splide.min.css">
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
<div class="container d-flex flex-column py-5 min-h-100">
HTML;
}

function render_footer($options = [])
{
    $showAnonymityNotice = $options['showAnonymityNotice'] ?? false;
    $pageType = $options['pageType'] ?? 'public';

    if ($showAnonymityNotice) {
        echo <<<HTML
<footer class="text-center text-muted mt-5 mb-3">
    <p class="small">Sua avaliação espontânea é anônima, nenhuma informação pessoal é solicitada ou armazenada.</p>
</footer>
HTML;
    }
    echo '</div>';
    
    echo '<script src="js/library/bootstrap.bundle.min.js"></script>';

    if ($pageType === 'public') {
        echo <<<HTML
<script src="js/library/splide.min.js"></script>
<script src="js/scripts.js"></script>
<script src="js/evaluation.js"></script>
HTML;
    }

    echo <<<HTML
</body>
</html>
HTML;
}
