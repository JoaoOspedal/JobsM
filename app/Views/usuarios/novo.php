<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Novo usuário</title>
    <link rel="stylesheet" href="/JobsM/public/assets/css/style.css">
</head>
<body>
    <div class="form-container">
        <h1 class="form-title">Cadastrar Novo Usuário</h1>
        <?php if (isset($_SESSION['erro'])): ?>
            <p style="color: red;"><?= htmlspecialchars($_SESSION['erro']) ?></p>
            <?php unset($_SESSION['erro']); ?>
        <?php endif; ?>

        <form class="form-group" action="/JobsM/public/usuarios/novo" method="POST">
            <input type="text" class="form-box" name="nome" placeholder="Nome completo" required>
            <input type="email" class="form-box" name="email" placeholder="email@email.com" required>
            <input type="password" class="form-box" name="senha" placeholder="••••••••" minlength="6" required>
            <button type="submit" class="bottons">Cadastrar</button>
        </form>
    </div>
</body>
</html>