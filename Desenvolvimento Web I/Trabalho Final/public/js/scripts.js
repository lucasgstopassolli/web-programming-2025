// scripts.js

document.addEventListener('DOMContentLoaded', function () {
    const slider = document.getElementById('question-slider');
    const prevBtn = document.getElementById('slider-prev-btn');
    const nextBtn = document.getElementById('slider-next-btn');
    const form = document.getElementById('survey-form');

    if (slider && prevBtn && nextBtn && form) {
        const splide = new Splide(slider, {
            direction: 'ttb', 
            rewind: true,
            perPage: 1,
            pagination: false,
            arrows: false,
            drag: false,
            height: '40vh',
            wheel: false,
            noDrag: 'input, textarea, .btn-group',
        });

        // Função para validar o slide atual
        function validateCurrentSlide() {
            const currentIndex = splide.index;
            const currentSlide = splide.Components.Slides.getAt(currentIndex).slide;
            const requiredInput = currentSlide.querySelector('input[type="radio"][required]');

            if (requiredInput) {
                const inputName = requiredInput.name;
                if (!form.querySelector(`input[name="${inputName}"]:checked`)) {
                    // Aplica a animação de "shake" para feedback visual
                    const questionContainer = currentSlide.querySelector('.question-container');
                    if (questionContainer) {
                        questionContainer.classList.add('shake');
                        setTimeout(() => questionContainer.classList.remove('shake'), 500);
                    }
                    return false; // Validação falhou
                }
            }
            return true; // Validação passou ou não há inputs obrigatórios
        }

        // Controla a visibilidade dos botões
        function updateNavButtons() {
            const currentIndex = splide.index;
            const totalSlides = splide.length;

            // Botão Voltar
            prevBtn.style.display = (currentIndex === 0) ? 'none' : 'inline-block';
            
            // Botão Avançar
            nextBtn.style.display = (currentIndex === totalSlides - 1) ? 'none' : 'inline-block';
        }

        // Evento do botão Avançar
        nextBtn.addEventListener('click', function () {
            if (validateCurrentSlide()) {
                splide.go('+1');
            }
        });

        // Evento do botão Voltar
        prevBtn.addEventListener('click', function () {
            splide.go('-1');
        });

        // Ouve o evento 'moved' para atualizar os botões após o movimento
        splide.on('moved', function () {
            updateNavButtons();
        });

        // Monta o carrossel e atualiza os botões na inicialização
        splide.mount();
        updateNavButtons();
    }
});

// Adiciona a animação de "shake" para o feedback de validação
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