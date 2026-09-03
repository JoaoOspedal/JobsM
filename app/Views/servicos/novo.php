<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Novo serviço</title>
</head>
<body>
    <h1>Novo serviço</h1>
    <form action="/JobsM/public/servicos/novo" method="POST">
        <label>Descrição: <input type="text" name="descricao" required></label><br>
        <label>Valor (R$): <input type="number" name="valor" step="0.01" min="0.01" required></label><br>
        <button type="submit">Salvar</button>
    </form>
    <a href="/JobsM/public/dashboard">Voltar</a>
</body>
</html>