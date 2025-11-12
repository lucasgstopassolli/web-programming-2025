<?php

/**
 * Arquivo para funções auxiliares globais.
 */

// Inclui as configurações da aplicação para usar constantes como APP_NAME
require_once __DIR__ . '/../config.php';

/**
 * Limpa e sanitiza uma string de entrada para exibição segura em HTML.
 *
 * @param mixed $data O dado a ser limpo. Se não for string, será retornado sem alterações.
 * @return mixed A string limpa ou o dado original.
 */
function sanitize_output($data)
{
    if (is_string($data)) {
        return htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
    }
    return $data;
}

/**
 * Renderiza o cabeçalho padrão da página HTML, incluindo os assets de CSS.
 *
 * @param string $pageTitle O título que aparecerá na aba do navegador.
 */
function render_header(string $pageTitle = APP_NAME): void
{
    $title = sanitize_output($pageTitle);

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

/**
 * Renderiza o rodapé padrão da página HTML, incluindo os assets de JS.
 *
 * @param bool \$showAnonymityNotice Controla a exibição da mensagem de anonimato.
 */
function render_footer(bool $showAnonymityNotice = false): void
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
