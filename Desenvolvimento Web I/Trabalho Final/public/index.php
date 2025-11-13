<?php
require_once '../src/function.php';
require_once '../src/question.php';

// É crucial obter o ID do dispositivo pela URL para saber de onde a avaliação está vindo.
// Exemplo de uso: http://seu-site.com/index.php?device=1
$device_id = isset($_GET['device']) ? (int)$_GET['device'] : null;

// Se nenhum ID de dispositivo for fornecido, a avaliação não pode continuar.
if (!$device_id) {
    render_header('Erro');
    echo '<div class="alert alert-danger text-center"><strong>Erro:</strong> ID do dispositivo não fornecido ou inválido. Por favor, contate o suporte.</div>';
    render_footer();
    exit;
}

// Busca as perguntas ativas do banco de dados
$questions = get_active_questions();

// Renderiza o cabeçalho da página
render_header('Avaliação de Satisfação');
?>

<div class="text-center">
    <!-- Você pode trocar este placeholder pelo logo da sua empresa -->
    <img src="https://via.placeholder.com/200x100?text=Logo+da+Empresa" alt="Logo da Empresa" class="mb-4" style="max-width: 200px;">
    <h1 class="h3 mb-3 fw-normal">Sua opinião é muito importante para nós!</h1>
    <p class="lead text-muted">Por favor, arraste para o lado e responda às perguntas.</p>
</div>

<!-- O formulário engloba todo o carrossel -->
<form action="submit_evaluation.php" method="POST" id="survey-form">
    <!-- Campo oculto para enviar o ID do dispositivo junto com as respostas -->
    <input type="hidden" name="device_id" value="<?= htmlspecialchars($device_id) ?>">

    <div id="question-slider" class="splide" aria-label="Formulário de Avaliação">
        <div class="splide__track">
            <ul class="splide__list">

                <?php foreach ($questions as $question): ?>
                <li class="splide__slide">
                    <div class="question-container text-center p-md-5 p-3">
                        <h2 class="h4 mb-4"><?= htmlspecialchars($question['question_text']) ?></h2>
                        
                        <?php if ($question['question_type'] === 'scale'): ?>
                            <div class="scale-container">
                                <div class="d-flex justify-content-between small text-muted mb-2">
                                    <span>Nada Satisfeito</span>
                                    <span>Muito Satisfeito</span>
                                </div>
                                <div class="btn-group" role="group" aria-label="Escala de avaliação">
                                    <?php for ($i = 0; $i <= 10; $i++): ?>
                                        <input type="radio" class="btn-check" name="answers[<?= $question['id'] ?>][scale]" id="q<?= $question['id'] ?>_<?= $i ?>" value="<?= $i ?>" autocomplete="off" required>
                                        <label class="btn btn-outline-primary" for="q<?= $question['id'] ?>_<?= $i ?>"><?= $i ?></label>
                                    <?php endfor; ?>
                                </div>
                            </div>
                        <?php elseif ($question['question_type'] === 'open'): ?>
                            <div class="w-100">
                                <textarea name="answers[<?= $question['id'] ?>][text]" class="form-control" rows="5" placeholder="Deixe aqui seu comentário (opcional)..."></textarea>
                            </div>
                        <?php endif; ?>
                    </div>
                </li>
                <?php endforeach; ?>

                <!-- Slide final para submissão -->
                <li class="splide__slide">
                    <div class="question-container text-center p-md-5 p-3 d-flex flex-column justify-content-center align-items-center">
                        <h2 class="h4 mb-4">Obrigado por sua colaboração!</h2>
                        <p class="text-muted">Clique no botão abaixo para finalizar e enviar suas respostas.</p>
                        <button type="submit" class="btn btn-success btn-lg mt-3">Finalizar Avaliação</button>
                    </div>
                </li>

            </ul>
        </div>
    </div>
</form>

<?php
// Renderiza o rodapé, incluindo o aviso de anonimato
render_footer(true);
?>
