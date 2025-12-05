<?php
require_once '../src/function.php';

// Tenta obter o ID do dispositivo da URL para o redirecionamento
$device_id = isset($_GET['device']) ? (int)$_GET['device'] : null;
$redirect_url = 'index.php' . ($device_id ? '?device=' . $device_id : '');

render_header('Obrigado!');
?>

<div class="text-center p-lg-5">
    <div class="py-5">
        <h1 class="display-4 text-success">✔ Obrigado!</h1>
        <p class="lead mt-4">
            O Estabelecimento agradece sua resposta e ela é muito importante para nós, 
            pois nos ajuda a melhorar continuamente nossos serviços.
        </p>
        <hr class="my-4">
        <p class="text-muted">Sua avaliação foi registrada com sucesso.</p>
        <p class="text-muted small">
            Esta página será recarregada em <span id="countdown">15</span> segundos.
        </p>
    </div>
</div>

<script>
    // Script para contagem regressiva e redirecionamento automático
    (function() {
        let seconds = 15;
        const countdownElement = document.getElementById('countdown');
        const redirectUrl = '<?= $redirect_url ?>';

        const interval = setInterval(() => {
            seconds--;
            if (countdownElement) {
                countdownElement.textContent = seconds;
            }
            if (seconds <= 0) {
                clearInterval(interval);
                window.location.href = redirectUrl;
            }
        }, 1000);
    })();
</script>

<?php
render_footer(['pageType' => 'public']);
?>
