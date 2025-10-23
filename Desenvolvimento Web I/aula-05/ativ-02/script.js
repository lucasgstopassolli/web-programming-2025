let mediaLinhaAdicionada = false;
let mediaColunaAdicionada = false;

document.getElementById("btn-media-notas").addEventListener("click", () => {
  if (mediaLinhaAdicionada) {
    alert("A linha de médias já foi adicionada.");
    return;
  }
  
  const tabela = document.getElementById("tabela-notas");
  const corpoTabela = tabela.querySelector("tbody");
  const linhasAlunos = corpoTabela.querySelectorAll("tr");
  const numAlunos = linhasAlunos.length;
  const numNotas = 9;
  const linhaMedia = corpoTabela.insertRow();
  const celulaTitulo = linhaMedia.insertCell();
  celulaTitulo.innerHTML = "<b>Média da Turma</b>";

  for (let i = 1; i <= numNotas; i++) {
    let soma = 0;
    linhasAlunos.forEach((linha) => {
      soma += parseFloat(linha.cells[i].innerText);
    });
    const media = soma / numAlunos;
    const celulaMedia = linhaMedia.insertCell();
    celulaMedia.innerHTML = `<b>${media.toFixed(2)}</b>`;
  }

  mediaLinhaAdicionada = true;
});

document.getElementById("btn-media-alunos").addEventListener("click", () => {
  if (mediaColunaAdicionada) {
    alert("A coluna de médias já foi adicionada.");
    return;
  }
  const tabela = document.getElementById("tabela-notas");
  const todasAsLinhas = tabela.querySelectorAll("tr");
  const cabecalhoPrincipal = todasAsLinhas[0];
  const novoCabecalho = document.createElement("th");
  novoCabecalho.textContent = "Média Final";
  novoCabecalho.classList.add("titulo-semestre");
  novoCabecalho.rowSpan = 2;
  cabecalhoPrincipal.appendChild(novoCabecalho);
  for (let i = 2; i < todasAsLinhas.length; i++) {
    const linhaAtual = todasAsLinhas[i];
    if (linhaAtual.cells[0].textContent === "Média da Turma") {
      const celulaVazia = linhaAtual.insertCell();
      continue;
    }
    let soma = 0;
    for (let j = 1; j < linhaAtual.cells.length; j++) {
      soma += parseFloat(linhaAtual.cells[j].innerText);
    }
    const media = soma / 9;
    const celulaMedia = linhaAtual.insertCell();
    celulaMedia.innerHTML = `<b>${media.toFixed(2)}</b>`;
  }
  mediaColunaAdicionada = true;
});
