<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Editar serviço</title>
</head>
<body>
    <h1>Editar serviço</h1>
    <form action="/JobsM/public/servicos/editar?id=<?= $servico['id'] ?>" method="POST" data-validar="servico">
        <label>Descrição: <input type="text" name="descricao" value="<?= htmlspecialchars($servico['descricao']) ?>" required></label><br>
        <label>Valor (R$): <input type="number" name="valor" step="0.01" min="0.01" value="<?= $servico['valor'] ?>" required></label><br>
        <button type="submit">Salvar</button>
    </form>
    <a href="/JobsM/public/dashboard">Voltar</a>

    <script src="/JobsM/public/assets/js/app.js"></script>
</body>
</html>