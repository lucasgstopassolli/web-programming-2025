<?php
require_once '../src/function.php';
require_once '../src/question.php';

$device_id = isset($_GET['device']) ? (int)$_GET['device'] : null;

// Se nenhum ID de dispositivo for fornecido, a avaliação não pode continuar.
if (!$device_id) {
    render_header('Erro');
    echo '<div class="alert alert-danger text-center"><strong>Erro:</strong> ID do dispositivo não fornecido ou inválido. Por favor, contate o suporte.</div>';
    render_footer(['pageType' => 'public']);
    exit;
}

// Busca as perguntas ativas para o dispositivo específico.
$questions = get_active_questions_for_device($device_id);

// Se não houver perguntas para este setor, exibe uma mensagem amigável.
if (empty($questions)) {
    render_header('Avaliação de Satisfação');
    echo '<div class="alert alert-info text-center">Não há perguntas de avaliação disponíveis para este setor no momento.</div>';
    render_footer(['pageType' => 'public']);
    exit;
}


// Renderiza o cabeçalho da página
render_header('Avaliação de Satisfação');
?>

<!-- O formulário engloba todo o carrossel -->
<form action="submit_evaluation.php" method="POST" id="survey-form" class="flex-grow-1 d-flex flex-column">
    <!-- Campo oculto para enviar o ID do dispositivo junto com as respostas -->
    <input type="hidden" name="device_id" value="<?= $device_id ?>">

    <div id="question-slider" class="splide flex-fill d-flex justify-content-center align-items-center h-100" aria-label="Formulário de Avaliação">
        <div class="splide__track">
            <ul class="splide__list">

                <?php foreach ($questions as $question): ?>
                    <li class="splide__slide">
                        <div class="question-container text-center p-3">
                            <h2 class="h4 mb-5"><?= htmlspecialchars($question['question_text']) ?></h2>

                            <?php if ($question['question_type'] === 'scale'): ?>
                                <div class="scale-container">
                                    <span>Nada Satisfeito</span>
                                        
                                    <div class="btn-group" role="group" aria-label="Escala de avaliação">
                                        <?php for ($i = 0; $i <= 10; $i++): ?>
                                            <input
                                                type="radio"
                                                class="btn-check"
                                                name="answers[<?= $question['id'] ?>][scale]"
                                                id="q<?= $question['id'] ?>_<?= $i ?>"
                                                value="<?= $i ?>"
                                                autocomplete="off"
                                                required>
                                            <label class="btn btn-outline-primary" for="q<?= $question['id'] ?>_<?= $i ?>"><?= $i ?></label>
                                        <?php endfor; ?>
                                    </div>
                                    <span>Muito Satisfeito</span>
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

        <!-- A barra de progresso agora faz parte do componente Splide -->
        <div class="splide__progress">
            <div class="splide__progress__bar"></div>
        </div>
    </div>

    <!-- Botões de Navegação -->
    <div class="d-flex justify-content-center gap-3 mt-3">
        <button type="button" id="slider-prev-btn" class="btn fs-4 btn-outline-secondary">Voltar</button>
        <button type="button" id="slider-next-btn" class="btn fs-4 btn-primary">Avançar</button>
    </div>
</form>

<?php
// Renderiza o rodapé, incluindo o aviso de anonimato
render_footer(['pageType' => 'public', 'showAnonymityNotice' => true]);
?>