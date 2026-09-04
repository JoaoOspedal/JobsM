<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Novo usuário</title>
</head>
<body>
    <h1>Novo usuário</h1>
    <?php if (isset($_SESSION['erro'])): ?>
        <p style="color: red;"><?= htmlspecialchars($_SESSION['erro']) ?></p>
        <?php unset($_SESSION['erro']); ?>
    <?php endif; ?>

    <form action="/JobsM/public/usuarios/novo" method="POST">
        <label>Nome: <input type="text" name="nome" required></label><br>
        <label>E-mail: <input type="email" name="email" required></label><br>
        <label>Senha: <input type="password" name="senha" minlength="6" required></label><br>
        <button type="submit">Salvar</button>
    </form>
</body>
</html>