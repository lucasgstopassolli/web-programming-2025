# Sistema de Avaliação de Satisfação

Um sistema simples em PHP para criar e gerenciar pesquisas de satisfação para diferentes setores de um estabelecimento, utilizando totens ou tablets como pontos de coleta.

## Tecnologias Utilizadas
- **Backend:** PHP 8+
- **Banco de Dados:** PostgreSQL
- **Frontend:** HTML, CSS, JavaScript, Bootstrap 5, Splide.js

## Funcionalidades
- **Painel Administrativo:** Interface para gerenciar perguntas, dispositivos (totens), e usuários administradores.
- **Gestão de Perguntas:** Crie perguntas de dois tipos:
    - **Escala Numérica:** Uma nota de 0 a 10.
    - **Texto Aberto:** Um campo para comentários e sugestões.
- **Segmentação por Setor:**
    - Cadastre dispositivos e associe cada um a um setor específico (ex: "Recepção", "Caixa", "Vendas").
    - Crie perguntas "globais" (exibidas em todos os setores) ou específicas para um ou mais setores.
- **Interface de Avaliação:** Página de avaliação limpa e direta para o cliente, acessada através de um link único por dispositivo.
- **Dashboard de Resultados:** Visualize a contagem de respostas, a média das notas para cada pergunta e leia os comentários deixados.

## Instalação

**Pré-requisitos:**
- Servidor web com suporte a PHP (ex: Apache, Nginx)
- PHP 8 ou superior
- PostgreSQL

**Passo a passo:**

1.  **Clone o repositório:**
    ```bash
    git clone https://github.com/lucasgstopassolli/web-programming-2025/blob/main/Desenvolvimento%20Web%20I/Trabalho%20Final/
    cd final-test
    ```

2.  **Configure o Banco de Dados:**
    - Crie um novo banco de dados no PostgreSQL. O nome padrão sugerido é `satisfaction_survey`.
    - Execute o script `sql/setup.sql` para criar todas as tabelas necessárias no seu banco de dados.

3.  **Configure a Conexão:**
    - Abra o arquivo `config.php`.
    - Altere as constantes `DB_HOST`, `DB_PORT`, `DB_NAME`, `DB_USER`, e `DB_PASS` com as informações do seu banco de dados.

4.  **Crie o Primeiro Usuário Administrador (Passo Crítico):**
    O sistema não possui uma tela de registro pública. O primeiro administrador deve ser criado manualmente.

    - **a) Gere o Hash da Senha:**
      Crie um arquivo PHP temporário ou use o terminal interativo do PHP (`php -a`) para executar o seguinte comando, substituindo `'admin123'` pela senha que desejar:
      ```php
      echo password_hash('admin123', PASSWORD_DEFAULT);
      ```
      Copie a string de hash gerada (algo como `$2y$10$...`).

    - **b) Insira o Usuário no Banco:**
      Execute a seguinte query SQL no seu banco de dados, substituindo `'admin'` pelo nome de usuário desejado e `'seu_hash_gerado_aqui'` pelo hash que você copiou no passo anterior:
      ```sql
      INSERT INTO admin_users (username, password) VALUES ('admin', 'seu_hash_gerado_aqui');
      ```

5.  **Inicie o Servidor:**
    - Aponte a raiz do seu servidor web para a pasta `public/` do projeto.
    - Alternativamente, use o servidor embutido do PHP (ótimo para desenvolvimento):
      ```bash
      php -S localhost:8000 -t public
      ```

## Como Usar

1.  **Acesse o Painel Administrativo:**
    - Abra `http://localhost:8000/admin.php` no seu navegador.
    - Faça login com as credenciais do usuário que você criou manualmente.

2.  **Cadastre os Dispositivos:**
    - Vá para a seção **Dispositivos**.
    - Clique em "Adicionar Novo Dispositivo".
    - Dê um nome ao dispositivo (ex: "Tablet do Caixa 01") e defina o **Setor** onde ele está localizado (ex: "Caixa"). O nome do setor é importante para vincular as perguntas.

3.  **Cadastre as Perguntas:**
    - Vá para a seção **Perguntas**.
    - Clique em "Adicionar Nova Pergunta".
    - Escreva o texto da pergunta, escolha o tipo e defina a ordem de exibição.
    - Marque a opção **"Global"** se a pergunta deve aparecer em todos os setores.
    - Se a pergunta for específica, deixe "Global" desmarcado e selecione um ou mais **Setores Específicos** na lista.

4.  **Inicie a Avaliação no Dispositivo:**
    - Volte para a lista de **Dispositivos**.
    - Para cada dispositivo, clique no botão **"Abrir Link"**.
    - A URL exibida (ex: `http://localhost:8000/index.php?device=1`) é o link que deve ser aberto no navegador do totem ou tablet daquele setor. É recomendado deixar o navegador em modo tela cheia (kiosk mode).

5.  **Acompanhe os Resultados:**
    - A página inicial do painel administrativo (Dashboard) mostrará as estatísticas e os últimos comentários recebidos.
