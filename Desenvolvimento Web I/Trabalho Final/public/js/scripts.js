// scripts.js

document.addEventListener('DOMContentLoaded', function () {
    const slider = document.getElementById('question-slider');

    // Verifica se o elemento do carrossel existe na página
    if (slider) {
        // Inicializa o Splide com configurações específicas para o formulário
        const splide = new Splide(slider, {
            type: 'slide',       // Comportamento de slide padrão (não é um loop)
            rewind: false,       // Não volta para o primeiro slide ao chegar no fim
            perPage: 1,          // Mostra um slide por vez
            pagination: true,    // Mostra os pontinhos de navegação na parte inferior
            arrows: true,        // Mostra as setas de avançar/voltar
            drag: true,          // Permite arrastar com o mouse ou o dedo (touch)
            
            // Impede que o gesto de arrastar comece em cima de botões ou campos de texto,
            // evitando conflitos de interação.
            noDrag: 'input, textarea, .btn-group', 
        });

        // Ouve o evento 'move' para fazer ajustes dinâmicos
        splide.on('move', (newIndex, oldIndex, destIndex) => {
            const form = document.getElementById('survey-form');
            const slide = splide.Components.Slides.getAt(oldIndex).slide;
            
            // Encontra o input de rádio obrigatório no slide anterior
            const requiredInput = slide.querySelector('input[type="radio"][required]');
            
            // Se existe um rádio obrigatório e ele não foi marcado, impede o avanço
            if (requiredInput && !form.querySelector(`input[name="${requiredInput.name}"]:checked`)) {
                // Previne o movimento
                splide.go(oldIndex); 
                
                // (Opcional) Adiciona um feedback visual
                const questionContainer = slide.querySelector('.question-container');
                questionContainer.classList.add('shake');
                setTimeout(() => questionContainer.classList.remove('shake'), 500);
            }
        });

        // Monta e renderiza o carrossel
        splide.mount();
    }
});

// Adiciona uma pequena animação de "shake" para o feedback de validação
const style = document.createElement('style');
style.innerHTML = `
@keyframes shake {
  10%, 90% { transform: translate3d(-1px, 0, 0); }
  20%, 80% { transform: translate3d(2px, 0, 0); }
  30%, 50%, 70% { transform: translate3d(-4px, 0, 0); }
  40%, 60% { transform: translate3d(4px, 0, 0); }
}
.shake {
  animation: shake 0.5s cubic-bezier(.36,.07,.19,.97) both;
}
`;
document.head.appendChild(style);
