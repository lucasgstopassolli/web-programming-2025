<?php
require_once '../src/auth.php';
require_once '../src/function.php';
require_once '../src/user.php';

// 1. Protege a página
require_login();

// 2. Controller: processa as ações
$action = isset($_GET['action']) ? $_GET['action'] : 'list';
$id = isset($_GET['id']) ? (int)$_GET['id'] : null;

$feedback_message = '';
$feedback_type = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = isset($_POST['id']) ? (int)$_POST['id'] : null;
    $username = isset($_POST['username']) ? $_POST['username'] : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';
    $password_confirm = isset($_POST['password_confirm']) ? $_POST['password_confirm'] : '';

    if (empty($username)) {
        $feedback_message = 'O nome de usuário é obrigatório.';
        $feedback_type = 'danger';
    } else {
        if ($id) { // Update
            if (!empty($password) && $password !== $password_confirm) {
                $feedback_message = 'As senhas não coincidem.';
                $feedback_type = 'danger';
            } else {
                $success = update_user($id, $username, $password);
                $feedback_message = $success ? 'Usuário atualizado com sucesso!' : 'Erro ao atualizar o usuário.';
                $feedback_type = $success ? 'success' : 'danger';
                if ($success) $action = 'list';
            }
        } else { // Create
            if (empty($password) || $password !== $password_confirm) {
                $feedback_message = 'A senha é obrigatória e as senhas devem coincidir.';
                $feedback_type = 'danger';
            } else {
                $success = create_user($username, $password);
                $feedback_message = $success ? 'Usuário criado com sucesso!' : 'Erro ao criar o usuário. O nome de usuário pode já existir.';
                $feedback_type = $success ? 'success' : 'danger';
                if ($success) $action = 'list';
            }
        }
    }
}

if ($action === 'delete' && $id) {
    // Impede que o usuário logado se auto-delete
    if (isset($_SESSION['user_id']) && $id === (int)$_SESSION['user_id']) {
        $feedback_message = 'Você não pode deletar o seu próprio usuário.';
        $feedback_type = 'danger';
    } else {
        $success = delete_user($id);
        $feedback_message = $success ? 'Usuário deletado com sucesso!' : 'Erro ao deletar o usuário.';
        $feedback_type = $success ? 'success' : 'danger';
    }
    $action = 'list';
}

// 3. View: Prepara os dados
$users = get_all_users();
$user_to_edit = ($action === 'edit' && $id) ? get_user_by_id($id) : null;
$form_title = $user_to_edit ? 'Editar Usuário' : 'Adicionar Novo Usuário';

// 4. Renderiza a página
render_header('Gerenciar Usuários');
?>

<h1>Gerenciar Usuários</h1>
<p class="lead">Adicione, edite ou remova os usuários com acesso ao painel administrativo.</p>

<?php include '_admin_nav.php'; ?>

<?php if ($feedback_message): ?>
<div class="alert alert-<?= $feedback_type ?> alert-dismissible fade show" role="alert">
    <?= htmlspecialchars($feedback_message) ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
<?php endif; ?>

<!-- Formulário de Adicionar/Editar -->
<div class="card mb-4" id="form-card">
    <div class="card-header"><?= $form_title ?></div>
    <div class="card-body">
        <form action="admin_users.php" method="POST">
            <input type="hidden" name="id" value="<?= $user_to_edit['id'] ?? '' ?>">
            
            <div class="mb-3">
                <label for="username" class="form-label">Nome de Usuário</label>
                <input type="text" class="form-control" id="username" name="username" value="<?= htmlspecialchars($user_to_edit['username'] ?? '') ?>" required>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="password" class="form-label">Nova Senha</label>
                    <input type="password" class="form-control" id="password" name="password" <?= $user_to_edit ? '' : 'required' ?>>
                    <div class="form-text"><?= $user_to_edit ? 'Deixe em branco para não alterar a senha.' : '' ?></div>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="password_confirm" class="form-label">Confirmar Nova Senha</label>
                    <input type="password" class="form-control" id="password_confirm" name="password_confirm" <?= $user_to_edit ? '' : 'required' ?>>
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Salvar Usuário</button>
            <?php if ($user_to_edit): ?>
            <a href="admin_users.php" class="btn btn-secondary">Cancelar Edição</a>
            <?php endif; ?>
        </form>
    </div>
</div>

<!-- Tabela de Usuários -->
<div class="card">
    <div class="card-header">Usuários Cadastrados</div>
    <div class="table-responsive">
        <table class="table table-striped table-hover mb-0">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome de Usuário</th>
                    <th class="text-center">Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($users)): ?>
                    <tr><td colspan="3" class="text-center p-4">Nenhum usuário cadastrado.</td></tr>
                <?php else: ?>
                    <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?= $user['id'] ?></td>
                        <td><?= htmlspecialchars($user['username']) ?></td>
                        <td class="text-center">
                            <a href="?action=edit&id=<?= $user['id'] ?>#form-card" class="btn btn-sm btn-warning" title="Editar">✏️</a>
                            <a href="?action=delete&id=<?= $user['id'] ?>" class="btn btn-sm btn-danger" title="Deletar" onclick="return confirm('Tem certeza que deseja deletar este usuário?')">🗑️</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php
render_footer(['pageType' => 'admin']);
?>
