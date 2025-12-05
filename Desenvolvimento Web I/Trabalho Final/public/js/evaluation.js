 // Função para gerar cor de vermelho → verde
  function getColor(value) {
    const max = 10;
    const percent = value / max;
    const r = Math.round(255 - percent * 255);
    const g = Math.round(percent * 200);
    return `rgb(${r}, ${g}, 80)`;
  }

  const groupSec = document.querySelectorAll('.btn-group')

  // Aplica a interação em cada grupo (caso tenha mais perguntas)
  groupSec.forEach(group => {
    const buttons = group.querySelectorAll('.btn-outline-primary');
    const radios = group.querySelectorAll('.btn-check');
    let selected = -1;

    buttons.forEach((btn, idx) => {
      const color = getColor(idx);
      btn.style.borderColor = color;
      btn.style.color = color;

      // Hover - colore todos os anteriores
      btn.addEventListener('mouseenter', () => {
        buttons.forEach((b, i) => {
          if (i <= idx) {
            const c = getColor(i);
            b.style.backgroundColor = c;
            b.style.borderColor = c;
            b.classList.add('active-rating');
          } else {
            b.style.backgroundColor = '';
            b.style.borderColor = getColor(i);
            b.classList.remove('active-rating');
            b.style.color = getColor(i);
          }
        });
      });

      // Sai do hover - restaura o selecionado
      btn.addEventListener('mouseleave', () => {
        buttons.forEach((b, i) => {
          if (i <= selected && selected >= 0) {
            const c = getColor(i);
            b.style.backgroundColor = c;
            b.style.borderColor = c;
            b.classList.add('active-rating');
          } else {
            b.style.backgroundColor = '';
            b.style.borderColor = getColor(i);
            b.classList.remove('active-rating');
            b.style.color = getColor(i);
          }
        });
      });

      // Clique - fixa seleção
      btn.addEventListener('click', () => {
        selected = idx;
        radios[idx].checked = true;
        
        // Dispara um evento 'change' no rádio para que outros scripts possam ouvi-lo
        const changeEvent = new Event('change', { bubbles: true });
        radios[idx].dispatchEvent(changeEvent);
      });
    });
  });