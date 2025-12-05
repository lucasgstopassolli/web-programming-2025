# Atividade 01

Esta atividade contém um projeto PHP simples que demonstra o uso de namespaces, classes e objetos.

## Arquivos

- `index.php`: Arquivo principal que instancia um objeto da classe `Pessoa` e exibe o nome completo e a idade.
- `executar_exercicios.php`: Arquivo que instancia objetos das classes `Pessoa`, `Endereco` e `Contato`, serializa os objetos em um arquivo de texto e em um arquivo JSON.
- `style.css`: Arquivo de estilo para a página `executar_exercicios.php`.
- `app/model/pessoa.php`: Classe que representa uma pessoa.
- `app/model/contato.php`: Classe que representa um contato.
- `app/model/endereco.php`: Classe que representa um endereço.

## Como executar

Para executar o projeto, você pode usar o servidor web de sua preferência ou o servidor embutido do PHP.

### Servidor embutido do PHP

Para iniciar o servidor embutido do PHP, execute o seguinte comando na raiz do projeto:

```bash
php -S localhost:8000
```

Em seguida, acesse `http://localhost:8000/executar_exercicios.php` no seu navegador.
