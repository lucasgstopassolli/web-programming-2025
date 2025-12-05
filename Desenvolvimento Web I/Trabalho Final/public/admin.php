<?php
session_start();
require_once '../src/auth.php';
require_once '../src/function.php';

$error_message = '';

// Processa a ação de logout
if (isset($_GET['action']) && $_GET['action'] === 'logout') {
    logout();
}

// Processa a tentativa de login
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    if (login($username, $password)) {
        // Se o login for bem-sucedido, redireciona para a própria página (já logado)
        header('Location: admin.php');
        exit;
    } else {
        $error_message = 'Usuário ou senha inválidos. Tente novamente.';
    }
}

// Se o usuário ESTÁ LOGADO, mostra o painel de administração
if (is_logged_in()) {
    
    require_once '../src/report.php';
    require_once '../src/device.php';

    // Lógica do Dashboard
    $sectors = get_all_sectors();
    $selected_sector = isset($_GET['sector']) ? $_GET['sector'] : null;

    // Se um setor inválido for selecionado, trata como "Todos"
    if ($selected_sector && !in_array($selected_sector, $sectors)) {
        $selected_sector = null;
    }

    $total_submissions = get_total_submissions_count($selected_sector);
    $avg_scores = get_average_scores_per_question($selected_sector);
    $text_feedbacks = get_text_feedbacks($selected_sector);



    render_header('Painel Administrativo');
?>
    <h1>Painel Administrativo</h1>
    <p class="lead">Bem-vindo, <?= htmlspecialchars($_SESSION['username']) ?>!</p>
    
    <?php include '_admin_nav.php'; ?>



    <!-- Tabela de Feedbacks -->
    <div class="card">
        <div class="card-header">Comentários e Sugestões</div>
        <div class="table-responsive">
            <table class="table table-striped table-hover mb-0">
                <thead>
                    <tr>
                        <th>Data</th>
                        <th>Setor</th>
                        <th>Dispositivo</th>
                        <th>Comentário</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($text_feedbacks)): ?>
                        <tr><td colspan="4" class="text-center p-4">Nenhum comentário recebido.</td></tr>
                    <?php else: ?>
                        <?php foreach ($text_feedbacks as $feedback): ?>
                        <tr>
                            <td><?= date('d/m/Y H:i', strtotime($feedback['created_at'])) ?></td>
                            <td><?= htmlspecialchars($feedback['sector']) ?></td>
                            <td><?= htmlspecialchars($feedback['device_name']) ?></td>
                            <td><?= htmlspecialchars($feedback['answer_text']) ?></td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>



<?php
    render_footer(['pageType' => 'admin']);
    exit; // Encerra o script para não renderizar o formulário de login abaixo
}

// 4. Se o usuário NÃO ESTÁ LOGADO, mostra o formulário de login
render_header('Login - Painel Administrativo');
?>

<div class="row justify-content-center mt-5">
    <div class="col-md-6 col-lg-4">
        <div class="card shadow-sm">
            <div class="card-body p-4">
                <h1 class="card-title text-center h3 mb-4">Acesso Restrito</h1>
                
                <?php if ($error_message): ?>
                    <div class="alert alert-danger" role="alert">
                        <?= htmlspecialchars($error_message) ?>
                    </div>
                <?php endif; ?>

                <form action="admin.php" method="POST">
                    <div class="mb-3">
                        <label for="username" class="form-label">Usuário</label>
                        <input type="text" class="form-control" id="username" name="username" required autofocus>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Senha</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <div class="d-grid mt-4">
                        <button type="submit" class="btn btn-primary btn-lg">Entrar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php
render_footer(['pageType' => 'admin']);
?>
