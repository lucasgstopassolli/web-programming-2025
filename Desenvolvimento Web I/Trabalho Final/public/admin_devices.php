<?php
require_once '../src/auth.php';
require_once '../src/function.php';
require_once '../src/device.php';

// 1. Protege a página
require_login();

// 2. Controller: processa as ações
$action = isset($_GET['action']) ? $_GET['action'] : 'list';
$id = isset($_GET['id']) ? (int)$_GET['id'] : null;

$feedback_message = '';
$feedback_type = '';

// Processa o envio de um formulário (Criação ou Atualização)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = isset($_POST['id']) ? (int)$_POST['id'] : null;
    $name = isset($_POST['name']) ? $_POST['name'] : '';
    $sector = isset($_POST['sector']) ? $_POST['sector'] : '';
    $status = isset($_POST['status']);

    if (empty($name) || empty($sector)) {
        $feedback_message = 'O nome e o setor do dispositivo são obrigatórios.';
        $feedback_type = 'danger';
    } else {
        if ($id) { // Update
            $success = update_device($id, $name, $sector, $status);
            $feedback_message = $success ? 'Dispositivo atualizado com sucesso!' : 'Erro ao atualizar o dispositivo.';
        } else { // Create
            $success = create_device($name, $sector, $status);
            $feedback_message = $success ? 'Dispositivo criado com sucesso!' : 'Erro ao criar o dispositivo.';
        }
        $feedback_type = $success ? 'success' : 'danger';
        $action = 'list';
    }
}

// Processa a ação de deletar
if ($action === 'delete' && $id) {
    $success = delete_device($id);
    $feedback_message = $success ? 'Dispositivo deletado com sucesso!' : 'Erro ao deletar o dispositivo.';
    $feedback_type = $success ? 'success' : 'danger';
    $action = 'list';
}


// 3. View: Prepara os dados
$devices = get_all_devices();
$device_to_edit = ($action === 'edit' && $id) ? get_device_by_id($id) : null;
$form_title = $device_to_edit ? 'Editar Dispositivo' : 'Adicionar Novo Dispositivo';

// 4. Renderiza a página
render_header('Gerenciar Dispositivos');
?>

<h1>Gerenciar Dispositivos</h1>
<p class="lead">Cadastre os tablets e os setores onde eles estão localizados (ex: Recepção, Caixa).</p>

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
        <form action="admin_devices.php" method="POST">
            <input type="hidden" name="id" value="<?= $device_to_edit['id'] ?? '' ?>">
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="name" class="form-label">Nome do Dispositivo</label>
                    <input type="text" class="form-control" id="name" name="name" value="<?= htmlspecialchars($device_to_edit['name'] ?? '') ?>" required>
                    <div class="form-text">Ex: "Tablet Recepção 01", "Totem Vendas"</div>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="sector" class="form-label">Setor</label>
                    <input type="text" class="form-control" id="sector" name="sector" value="<?= htmlspecialchars($device_to_edit['sector'] ?? '') ?>" required>
                    <div class="form-text">Ex: "Recepção", "Vendas", "Caixa"</div>
                </div>
            </div>

            <div class="mb-3">
                <div class="form-check form-switch fs-5">
                    <input class="form-check-input" type="checkbox" role="switch" id="status" name="status" <?= ($device_to_edit['status'] ?? true) ? 'checked' : '' ?>>
                    <label class="form-check-label" for="status">Ativo</label>
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Salvar Dispositivo</button>
            <?php if ($device_to_edit): ?>
            <a href="admin_devices.php" class="btn btn-secondary">Cancelar Edição</a>
            <?php endif; ?>
        </form>
    </div>
</div>

<!-- Tabela de Dispositivos -->
<div class="card">
    <div class="card-header">Dispositivos Cadastrados</div>
    <div class="table-responsive">
        <table class="table table-striped table-hover mb-0">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Setor</th>
                    <th class="text-center">Status</th>
                    <th class="text-center">Link da Avaliação</th>
                    <th class="text-center">Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($devices)): ?>
                    <tr><td colspan="6" class="text-center p-4">Nenhum dispositivo cadastrado.</td></tr>
                <?php else: ?>
                    <?php foreach ($devices as $device): ?>
                    <tr>
                        <td><?= $device['id'] ?></td>
                        <td><?= htmlspecialchars($device['name']) ?></td>
                        <td><?= htmlspecialchars($device['sector']) ?></td>
                        <td class="text-center">
                            <span class="badge <?= $device['status'] ? 'bg-success' : 'bg-secondary' ?>">
                                <?= $device['status'] ? 'Ativo' : 'Inativo' ?>
                            </span>
                        </td>
                        <td class="text-center">
                            <a href="index.php?device=<?= $device['id'] ?>" target="_blank" class="btn btn-sm btn-outline-primary">Abrir Link</a>
                        </td>
                        <td class="text-center">
                            <a href="?action=edit&id=<?= $device['id'] ?>#form-card" class="btn btn-sm btn-warning" title="Editar">✏️</a>
                            <a href="?action=delete&id=<?= $device['id'] ?>" class="btn btn-sm btn-danger" title="Deletar" onclick="return confirm('Tem certeza que deseja deletar este dispositivo? Todas as avaliações associadas a ele também serão removidas.')">🗑️</a>
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
