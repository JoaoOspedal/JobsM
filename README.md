# JobsM: Sistema de Ordens de Serviço
Sistema criado para o teste de processo seletivo da Titan Software

## Tecnologias

- PHP 8+
- MySQL, acessado via PDO com prepared statements
- Arquitetura MVC, roteador e autoload (`spl_autoload_register`)
- JavaScript pra validação de formulário e confirmações de ação
- Apache com `mod_rewrite` (recomendo Laragon pra rodar local, é o que usei no desenvolvimento)

## Funções

Um funcionário loga no sistema e cai numa Dashboard que mostra:

- Os dados de quem está logado e a data atual
- Uma tabela com todos os serviços prestados (id, descrição, status, valor, responsável)
- O valor total já prestado por ele, em destaque
- Uma lista rápida dos serviços dele que ainda estão pendentes
- Filtros por período, nome do serviço, status e usuário

De lá, dá pra cadastrar um novo serviço, editar ou excluir um existente, e finalizar um serviço pendente, calcula a comissão automaticamente e dispara um e-mail avisando o responsável.

## Rodando o projeto localmente

Pré-requisitos: Laragon (ou qualquer PHP 8+ com Apache/MySQL e `mod_rewrite` habilitado).

1. Baixar o Laragon pra rodar o projeto:

    ```bash
    https://laragon.org/download
    ```

2. Copiar ou clonar o repositório dentro da pasta `www` do Laragon:

   ```bash
   cd C:\laragon\www
   git clone https://github.com/seu-usuario/JobsM.git
   ```

3. No Laragon, apertar botão "Start All" pra subir o Apache e o MySQL

4. Crie o banco e as tabelas no HeidiSQL (Laragon > Menu > Database):

   ```sql
   CREATE DATABASE IF NOT EXISTS jobsm;
   USE jobsm;

   CREATE TABLE usuarios (
       id INT AUTO_INCREMENT PRIMARY KEY,
       nome VARCHAR(100) NOT NULL,
       email VARCHAR(150) NOT NULL UNIQUE,
       senha VARCHAR(255) NOT NULL,
       created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
   );

   CREATE TABLE servicos (
       id INT AUTO_INCREMENT PRIMARY KEY,
       descricao VARCHAR(255) NOT NULL,
       valor DECIMAL(10,2) NOT NULL,
       usuario_id INT NOT NULL,
       data_criacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
       data_finalizacao DATETIME NULL,
       comissao DECIMAL(10,2) NULL,
       FOREIGN KEY (usuario_id) REFERENCES usuarios(id)
   );
   ```

5. Acesse `localhost/JobsM/public/` no navegador. Você vai cair na tela de login mas ainda não existe ninguém cadastrado, então:

6. Vá em `localhost/JobsM/public/usuarios/novo` e crie sua própria conta (nome [decidi criar um campo "nome" pra exibição no dashboard], e-mail e uma senha com pelo menos 6 caracteres). Então realize o login.

As credenciais do banco estão fixas em `app/Core/Database.php`, que é o padrão do Laragon.

## Regras de negócio

Status do serviço não é um campo salvo, é calculado. Em vez de guardar "Pendente" ou "Finalizado" como texto (que poderia ficar dessincronizado se alguém esquecesse de atualizar os dois campos juntos), o status sai direto da presença ou ausência de `data_finalizacao`.
Comissão é por faixa de valor, calculada no momento em que o serviço é finalizado.

## Estrutura de pastas

```
JobsM/
├── app/
│   ├── Controllers/
│   ├── Models/
│   ├── Views/
│   └── Core/
│       ├── autoload.php   # autoload manual
│       ├── Database.php   # conexão PDO única
│       ├── Router.php
│       └── Auth.php       # protege rotas que exigem login
├── public/
│   ├── index.php          # front controller
│   ├── .htaccess          # redireciona tudo pro index.php
│   └── assets/js/app.js
└── README.md
```

## Sobre a validação

A validação acontece nos dois lados. O HTML usa `required` e o JavaScript confere antes de enviar, mas nenhum dos dois é a proteção de verdade. Quem realmente garante que nada inválido entra no banco é a validação em PHP, do lado do servidor, em cada Controller.

## O que faltaria



- O envio de e-mail na finalização usa a função `mail()` nativa do PHP. Ela roda sem erro e cumpre a lógica, mas sem um SMTP configurado (tipo Mailtrap), localmente ela não entrega nada de verdade pois não foi solicitado no desafio.


