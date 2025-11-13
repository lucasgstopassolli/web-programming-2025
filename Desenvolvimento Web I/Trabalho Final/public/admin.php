<?php
session_start();
require_once '../src/auth.php';
require_once '../src/function.php';

$error_message = '';

// --- LÓGICA DE CONTROLE ---

// 1. Processa a ação de logout
if (isset($_GET['action']) && $_GET['action'] === 'logout') {
    logout();
}

// 2. Processa a tentativa de login
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

// --- RENDERIZAÇÃO DA PÁGINA ---

// 3. Se o usuário ESTÁ LOGADO, mostra o painel de administração
if (is_logged_in()) {
    
    require_once '../src/report.php';

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

    // Prepara dados para o gráfico
    $chart_labels = json_encode(array_map(function($item) { return $item['question_text']; }, $avg_scores));
    $chart_data = json_encode(array_map(function($item) { return round($item['average_score'], 2); }, $avg_scores));

    render_header('Painel Administrativo');
?>
    <h1>Painel Administrativo</h1>
    <p class="lead">Bem-vindo, <?= htmlspecialchars($_SESSION['username']) ?>!</p>
    
    <?php include '_admin_nav.php'; ?>

    <h2>Dashboard</h2>
    
    <!-- Filtro por Setor -->
    <div class="card mb-4">
        <div class="card-body">
            <form action="admin.php" method="GET" class="row g-3 align-items-center">
                <div class="col-auto">
                    <label for="sector" class="col-form-label">Filtrar por Setor:</label>
                </div>
                <div class="col-auto">
                    <select name="sector" id="sector" class="form-select" onchange="this.form.submit()">
                        <option value="">-- Todos os Setores --</option>
                        <?php foreach ($sectors as $sector): ?>
                            <option value="<?= htmlspecialchars($sector) ?>" <?= ($selected_sector === $sector) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($sector) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-auto">
                    <a href="admin.php" class="btn btn-secondary">Limpar Filtro</a>
                </div>
            </form>
        </div>
    </div>

    <!-- Métricas e Gráfico -->
    <div class="row">
        <div class="col-lg-8">
            <div class="card mb-4">
                <div class="card-header">Média de Pontuação por Pergunta</div>
                <div class="card-body">
                    <canvas id="averageScoresChart"></canvas>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card text-center">
                <div class="card-header">Total de Avaliações</div>
                <div class="card-body">
                    <h2 class="display-4"><?= $total_submissions ?></h2>
                </div>
            </div>
        </div>
    </div>

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

    <script src="js/library/chart.umd.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('averageScoresChart');
            if (ctx) {
                new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: <?= $chart_labels ?>,
                        datasets: [{
                            label: 'Pontuação Média',
                            data: <?= $chart_data ?>,
                            backgroundColor: 'rgba(0, 123, 255, 0.5)',
                            borderColor: 'rgba(0, 123, 255, 1)',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            y: {
                                beginAtZero: true,
                                max: 10 // Define o máximo da escala Y para 10
                            }
                        },
                        plugins: {
                            legend: {
                                display: false
                            }
                        }
                    }
                });
            }
        });
    </script>

<?php
    render_footer();
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
render_footer();
?>
