<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
</head>
<body>
    <h1>Login</h1>

    <?php if (isset($_SESSION['erro'])): ?>
        <p style="color: red;"><?= htmlspecialchars($_SESSION['erro']) ?></p>
        <?php unset($_SESSION['erro']); ?>
    <?php endif; ?>
    
    <?php if (isset($_SESSION['sucesso'])): ?>
        <p style="color: green;"><?= htmlspecialchars($_SESSION['sucesso']) ?></p>
        <?php unset($_SESSION['sucesso']); ?>
    <?php endif; ?>

    <form action="/JobsM/public/login" method="POST">
        <label>E-mail: <input type="email" name="email" required></label><br>
        <label>Senha: <input type="password" name="senha" required></label><br>
        <button type="submit">Entrar</button>
    </form>
</body>
</html>