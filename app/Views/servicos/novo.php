<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Novo serviço</title>
    <link rel="stylesheet" href="/JobsM/public/assets/css/style.css">
</head>
<body>
    <div class="form-container">
        <h1 class="form-title">Novo serviço</h1>
        <form class="form-group" action="/JobsM/public/servicos/novo" method="POST" data-validar="servico">
            <input type="text" class="form-box" name="descricao" placeholder="Descrição" required>
            <input type="number" class="form-box" name="valor" placeholder="Valor (R$)" step="0.01" min="0.01" required>
            <button type="submit" class="bottons">Salvar</button>
        </form>
    </div>

    <script src="/JobsM/public/assets/js/app.js"></script>
</body>
</html>
