<?php
require_once '../src/auth.php';
require_once '../src/function.php';
require_once '../src/question.php';
require_once '../src/device.php'; // Para pegar a lista de setores

// 1. Protege a página
require_login();

// 2. Lógica do Controller
$action = isset($_GET['action']) ? $_GET['action'] : 'list';
$id = isset($_GET['id']) ? (int)$_GET['id'] : null;

$feedback_message = '';
$feedback_type = '';

// Processa o envio de um formulário (Criação ou Atualização)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = isset($_POST['id']) ? (int)$_POST['id'] : null;
    $text = isset($_POST['question_text']) ? trim($_POST['question_text']) : '';
    $type = isset($_POST['question_type']) ? $_POST['question_type'] : 'scale';
    $order = isset($_POST['display_order']) ? (int)$_POST['display_order'] : 0;
    $status = isset($_POST['status']);
    $is_global = isset($_POST['is_global']);
    $sectors = isset($_POST['sectors']) && is_array($_POST['sectors']) ? $_POST['sectors'] : [];

    if (empty($text)) {
        $feedback_message = 'O texto da pergunta não pode estar vazio.';
        $feedback_type = 'danger';
    } elseif (!$is_global && empty($sectors)) {
        $feedback_message = 'Uma pergunta não-global deve ser associada a pelo menos um setor.';
        $feedback_type = 'warning';
    } else {
        if ($id) { // Update
            $success = update_question($id, $text, $type, $order, $status, $is_global, $sectors);
            $feedback_message = $success ? 'Pergunta atualizada com sucesso!' : 'Erro ao atualizar a pergunta.';
        } else { // Create
            $success = create_question($text, $type, $order, $status, $is_global, $sectors);
            $feedback_message = $success ? 'Pergunta criada com sucesso!' : 'Erro ao criar a pergunta.';
        }
        $feedback_type = $success ? 'success' : 'danger';
        if ($success) {
            $action = 'list';
        }
    }
}

// Processa a ação de deletar
if ($action === 'delete' && $id) {
    $success = delete_question($id);
    $feedback_message = $success ? 'Pergunta deletada com sucesso!' : 'Erro ao deletar a pergunta.';
    $feedback_type = $success ? 'success' : 'danger';
    $action = 'list';
}

// 3. Prepara os dados para a View
$all_questions = get_all_questions();
$all_sectors = get_all_sectors(); // Pega todos os setores únicos dos dispositivos
$question_to_edit = ($action === 'edit' && $id) ? get_question_by_id($id) : null;
$form_title = $question_to_edit ? 'Editar Pergunta' : 'Adicionar Nova Pergunta';

// 4. Renderiza a View
render_header('Gerenciar Perguntas');
?>

<h1>Gerenciar Perguntas</h1>
<p class="lead">Adicione, edite ou remova as perguntas da avaliação, definindo se são globais ou específicas para alguns setores.</p>

<?php include '_admin_nav.php'; ?>

<?php if ($feedback_message): ?>
<div class="alert alert-<?= $feedback_type ?> alert-dismissible fade show" role="alert">
    <?= htmlspecialchars($feedback_message) ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
<?php endif; ?>

<!-- Formulário de Adicionar/Editar Pergunta -->
<div class="card mb-4" id="form-card">
    <div class="card-header"><?= $form_title ?></div>
    <div class="card-body">
        <form action="admin_questions.php" method="POST">
            <input type="hidden" name="id" value="<?= $question_to_edit['id'] ?? '' ?>">
            
            <div class="mb-3">
                <label for="question_text" class="form-label">Texto da Pergunta</label>
                <textarea class="form-control" id="question_text" name="question_text" rows="2" required><?= htmlspecialchars($question_to_edit['question_text'] ?? '') ?></textarea>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="question_type" class="form-label">Tipo de Pergunta</label>
                    <select class="form-select" id="question_type" name="question_type">
                        <option value="scale" <?= (($question_to_edit['question_type'] ?? 'scale') === 'scale') ? 'selected' : '' ?>>Escala Numérica</option>
                        <option value="open" <?= (($question_to_edit['question_type'] ?? '') === 'open') ? 'selected' : '' ?>>Texto Aberto</option>
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="display_order" class="form-label">Ordem de Exibição</label>
                    <input type="number" class="form-control" id="display_order" name="display_order" value="<?= $question_to_edit['display_order'] ?? 0 ?>">
                </div>
            </div>

            <div class="row align-items-center">
                <div class="col-md-auto">
                    <div class="form-check form-switch fs-5">
                        <input class="form-check-input" type="checkbox" role="switch" id="status" name="status" <?= filter_var(($question_to_edit['status'] ?? true), FILTER_VALIDATE_BOOLEAN) ? 'checked' : '' ?>>
                        <label class="form-check-label" for="status">Ativa</label>
                    </div>
                </div>
                <div class="col-md-auto">
                    <div class="form-check form-switch fs-5">
                        <?php if (isset($question_to_edit)) var_dump($question_to_edit['is_global']); ?>
                        <input class="form-check-input" type="checkbox" role="switch" id="is_global" name="is_global" <?= filter_var(($question_to_edit['is_global'] ?? false), FILTER_VALIDATE_BOOLEAN) ? 'checked' : '' ?>>
                        <label class="form-check-label" for="is_global">Global (todos os setores)</label>
                    </div>
                </div>
            </div>
            
            <div class="mb-3 mt-3" id="sectors-container">
                <label for="sectors" class="form-label">Setores Específicos</label>
                <select class="form-select" id="sectors" name="sectors[]" multiple size="5">
                    <?php foreach ($all_sectors as $sector): ?>
                        <option value="<?= htmlspecialchars($sector) ?>" <?= (in_array($sector, $question_to_edit['sectors'] ?? [])) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($sector) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <div class="form-text">Segure Ctrl (ou Cmd em Mac) para selecionar múltiplos setores. Esta opção é ignorada se a pergunta for "Global".</div>
            </div>

            <button type="submit" class="btn btn-primary">Salvar Pergunta</button>
            <?php if ($question_to_edit): ?>
            <a href="admin_questions.php" class="btn btn-secondary">Cancelar Edição</a>
            <?php endif; ?>
        </form>
    </div>
</div>

<!-- Tabela de Perguntas Cadastradas -->
<div class="card">
    <div class="card-header">Perguntas Cadastradas</div>
    <div class="table-responsive">
        <table class="table table-striped table-hover mb-0 align-middle">
            <thead>
                <tr>
                    <th class="text-center" style="width: 5%;">Ordem</th>
                    <th>Pergunta</th>
                    <th style="width: 15%;">Tipo</th>
                    <th style="width: 20%;">Abrangência</th>
                    <th class="text-center" style="width: 10%;">Status</th>
                    <th class="text-center" style="width: 10%;">Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($all_questions)): ?>
                    <tr><td colspan="6" class="text-center p-4">Nenhuma pergunta cadastrada ainda.</td></tr>
                <?php else: ?>
                    <?php foreach ($all_questions as $question): ?>
                    <tr>
                        <td class="text-center"><?= htmlspecialchars($question['display_order']) ?></td>
                        <td><?= htmlspecialchars($question['question_text']) ?></td>
                        <td><?= $question['question_type'] === 'scale' ? 'Escala Numérica' : 'Texto Aberto' ?></td>
                        <td>
                            <?php if (filter_var($question['is_global'], FILTER_VALIDATE_BOOLEAN)): ?>
                                <span class="badge bg-info">Global</span>
                            <?php else: 
                                $sectors = get_sectors_for_question($question['id']);
                                if (empty($sectors)) {
                                    echo '<span class="badge bg-warning">Nenhum setor</span>';
                                } else {
                                    foreach($sectors as $sector) {
                                        echo '<span class="badge bg-light text-dark me-1">' . htmlspecialchars($sector) . '</span>';
                                    }
                                }
                            endif; ?>
                        </td>
                        <td class="text-center">
                            <span class="badge <?= filter_var($question['status'], FILTER_VALIDATE_BOOLEAN) ? 'bg-success' : 'bg-secondary' ?>">
                                <?= filter_var($question['status'], FILTER_VALIDATE_BOOLEAN) ? 'Ativa' : 'Inativa' ?>
                            </span>
                        </td>
                        <td class="text-center">
                            <a href="?action=edit&id=<?= $question['id'] ?>#form-card" class="btn btn-sm btn-warning" title="Editar">✏️</a>
                            <a href="?action=delete&id=<?= $question['id'] ?>" class="btn btn-sm btn-danger" title="Deletar" onclick="return confirm('Tem certeza que deseja deletar esta pergunta? Esta ação não pode ser desfeita.')">🗑️</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const isGlobalCheckbox = document.getElementById('is_global');
    const sectorsContainer = document.getElementById('sectors-container');
    const sectorsSelect = document.getElementById('sectors');

    function toggleSectors() {
        if (isGlobalCheckbox.checked) {
            sectorsContainer.style.display = 'none';
            sectorsSelect.disabled = true;
        } else {
            sectorsContainer.style.display = 'block';
            sectorsSelect.disabled = false;
        }
    }

    isGlobalCheckbox.addEventListener('change', toggleSectors);
    
    // Executa na inicialização para definir o estado correto do formulário
    toggleSectors();
});
</script>

<?php
render_footer();
?>