<?php
require_once '../src/auth.php';
require_once '../src/function.php';
require_once '../src/question.php';

// 1. Protege a página: apenas usuários logados podem acessar.
require_login();

// 2. Lógica do Controller: processa as ações de CRUD
$action = isset($_GET['action']) ? $_GET['action'] : 'list';
$id = isset($_GET['id']) ? (int)$_GET['id'] : null;

$feedback_message = '';
$feedback_type = '';

// Processa o envio de um formulário (Criação ou Atualização)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = isset($_POST['id']) ? (int)$_POST['id'] : null;
    $text = isset($_POST['question_text']) ? $_POST['question_text'] : '';
    $type = isset($_POST['question_type']) ? $_POST['question_type'] : 'scale';
    $order = isset($_POST['display_order']) ? (int)$_POST['display_order'] : 0;
    $status = isset($_POST['status']); // true se o checkbox estiver marcado, false caso contrário

    if (empty($text)) {
        $feedback_message = 'O texto da pergunta não pode estar vazio.';
        $feedback_type = 'danger';
    } else {
        if ($id) { // Se tem ID, é uma atualização
            $success = update_question($id, $text, $type, $order, $status);
            $feedback_message = $success ? 'Pergunta atualizada com sucesso!' : 'Erro ao atualizar a pergunta.';
        } else { // Se não tem ID, é uma criação
            $success = create_question($text, $type, $order, $status);
            $feedback_message = $success ? 'Pergunta criada com sucesso!' : 'Erro ao criar a pergunta.';
        }
        $feedback_type = $success ? 'success' : 'danger';
        $action = 'list'; // Volta para a listagem após a ação
    }
}

// Processa a ação de deletar
if ($action === 'delete' && $id) {
    $success = delete_question($id);
    $feedback_message = $success ? 'Pergunta deletada com sucesso!' : 'Erro ao deletar a pergunta. Verifique se ela não está em uso.';
    $feedback_type = $success ? 'success' : 'danger';
    $action = 'list'; // Volta para a listagem
}

// 3. Prepara os dados para a View
$questions = get_all_questions();
$question_to_edit = ($action === 'edit' && $id) ? get_question_by_id($id) : null;
$form_title = $question_to_edit ? 'Editar Pergunta' : 'Adicionar Nova Pergunta';

// 4. Renderiza a View
render_header('Gerenciar Perguntas');
?>

<h1>Gerenciar Perguntas</h1>
<p class="lead">Adicione, edite ou remova as perguntas que aparecerão na avaliação.</p>

<?php include '_admin_nav.php'; // Inclui a navegação do admin ?>

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
                <textarea class="form-control" id="question_text" name="question_text" rows="3" required><?= htmlspecialchars($question_to_edit['question_text'] ?? '') ?></textarea>
            </div>

            <div class="row">
                <div class="col-md-4 mb-3">
                    <label for="question_type" class="form-label">Tipo de Pergunta</label>
                    <select class="form-select" id="question_type" name="question_type">
                        <option value="scale" <?= (($question_to_edit['question_type'] ?? 'scale') === 'scale') ? 'selected' : '' ?>>Escala Numérica</option>
                        <option value="open" <?= (($question_to_edit['question_type'] ?? '') === 'open') ? 'selected' : '' ?>>Texto Aberto</option>
                    </select>
                </div>
                <div class="col-md-4 mb-3">
                    <label for="display_order" class="form-label">Ordem de Exibição</label>
                    <input type="number" class="form-control" id="display_order" name="display_order" value="<?= $question_to_edit['display_order'] ?? 0 ?>">
                </div>
                <div class="col-md-4 mb-3 d-flex align-items-end">
                    <div class="form-check form-switch fs-5">
                        <input class="form-check-input" type="checkbox" role="switch" id="status" name="status" <?= ($question_to_edit['status'] ?? true) ? 'checked' : '' ?>>
                        <label class="form-check-label" for="status">Ativa</label>
                    </div>
                </div>
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
        <table class="table table-striped table-hover mb-0">
            <thead>
                <tr>
                    <th class="text-center">Ordem</th>
                    <th>Pergunta</th>
                    <th>Tipo</th>
                    <th class="text-center">Status</th>
                    <th class="text-center">Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($questions)): ?>
                    <tr><td colspan="5" class="text-center p-4">Nenhuma pergunta cadastrada ainda.</td></tr>
                <?php else: ?>
                    <?php foreach ($questions as $question): ?>
                    <tr>
                        <td class="text-center"><?= htmlspecialchars($question['display_order']) ?></td>
                        <td><?= htmlspecialchars($question['question_text']) ?></td>
                        <td><?= $question['question_type'] === 'scale' ? 'Escala' : 'Texto' ?></td>
                        <td class="text-center">
                            <span class="badge <?= $question['status'] ? 'bg-success' : 'bg-secondary' ?>">
                                <?= $question['status'] ? 'Ativa' : 'Inativa' ?>
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

<?php
render_footer();
?>
