<?php

// Garante que o script só seja executado em requisições do tipo POST.
// Se alguém tentar acessar este arquivo diretamente pela URL, será redirecionado.
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit;
}

require_once '../src/answer.php';
require_once '../src/function.php'; // Para usar as funções de renderização em caso de erro

// Filtra e valida os dados recebidos do formulário
$device_id = isset($_POST['device_id']) ? (int)$_POST['device_id'] : null;
$answers = isset($_POST['answers']) ? $_POST['answers'] : []; // Usa o operador de coalescência nula para evitar erros se 'answers' não for enviado

// Verifica se os dados essenciais (ID do dispositivo e as respostas) estão presentes
if (!$device_id || empty($answers)) {
    render_header('Erro de Submissão');
    echo '<div class="alert alert-warning text-center">Não foi possível processar sua avaliação. Dados inválidos ou ausentes.</div>';
    render_footer();
    exit;
}

// Tenta salvar a avaliação no banco de dados
$success = save_evaluation($device_id, $answers);

// Redireciona o usuário com base no resultado da operação
if ($success) {
    // Se salvou com sucesso, redireciona para a página de agradecimento, passando o ID do dispositivo
    header('Location: thank-you.php?device=' . $device_id);
    exit;
} else {
    // Se falhou, exibe uma mensagem de erro genérica
    render_header('Erro ao Salvar');
    echo '<div class="alert alert-danger text-center">Ocorreu um erro inesperado ao salvar sua avaliação. Por favor, tente novamente.</div>';
    render_footer();
    exit;
}
