<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="/JobsM/public/assets/css/style.css">
</head>
<body>
    <div class="form-container">
        <h1 class="form-title">Sistema de Controle de Serviços</h1>

        <?php if (isset($_SESSION['erro'])): ?>
            <p style="color: red;"><?= htmlspecialchars($_SESSION['erro']) ?></p>
            <?php unset($_SESSION['erro']); ?>
        <?php endif; ?>
        
        <?php if (isset($_SESSION['sucesso'])): ?>
            <p style="color: green;"><?= htmlspecialchars($_SESSION['sucesso']) ?></p>
            <?php unset($_SESSION['sucesso']); ?>
        <?php endif; ?>

        <form class="form-group" action="/JobsM/public/login" method="POST">
            <input type="email" class="form-box" name="email" placeholder="email@email.com" required>
            <input type="password" class="form-box" name="senha" placeholder="••••••••" required>
            <div class="bottons--login">
                <button type="submit" class="bottons">Entrar</button>
                <a href="/JobsM/public/usuarios/novo">Cadastrar usuário</a>
            </div>
        </form>
    </div>
</body>
</html>