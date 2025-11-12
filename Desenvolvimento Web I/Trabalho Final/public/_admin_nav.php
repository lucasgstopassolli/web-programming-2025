<?php
/**
 * Fragmento de Navegação do Painel Administrativo.
 *
 * Este arquivo é incluído nas páginas da área de administração para
 * gerar o menu de navegação de forma consistente.
 *
 * Ele detecta a página atual e aplica a classe 'active' do Bootstrap
 * ao link correspondente.
 */

// Pega o nome do script atual para saber qual link marcar como 'ativo'
$current_page = basename($_SERVER['SCRIPT_NAME']);
?>

<nav class="nav nav-pills mb-4">
    <a class="nav-link <?= ($current_page === 'admin.php') ? 'active' : '' ?>" href="admin.php">Dashboard</a>
    <a class="nav-link <?= ($current_page === 'admin_questions.php') ? 'active' : '' ?>" href="admin_questions.php">Perguntas</a>
    <a class="nav-link <?= ($current_page === 'admin_devices.php') ? 'active' : '' ?>" href="admin_devices.php">Dispositivos</a>
    <a class="nav-link ms-auto btn btn-outline-danger" href="admin.php?action=logout">Sair</a>
</nav>
