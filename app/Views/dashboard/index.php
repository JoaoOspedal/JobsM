<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
</head>
<body>
    <header>
        <p>Usuário: <?= htmlspecialchars($_SESSION['usuario_nome']) ?> (<?= htmlspecialchars($_SESSION['usuario_email']) ?>)</p>
        <p>Data: <?= date('d/m/Y') ?></p>
        <a href="/JobsM/public/logout">Sair</a>
    </header>

    <?php if (isset($_SESSION['sucesso'])): ?>
        <p style="color: green;"><?= htmlspecialchars($_SESSION['sucesso']) ?></p>
        <?php unset($_SESSION['sucesso']); ?>
    <?php endif; ?>
    <?php if (isset($_SESSION['erro'])): ?>
        <p style="color: red;"><?= htmlspecialchars($_SESSION['erro']) ?></p>
        <?php unset($_SESSION['erro']); ?>
    <?php endif; ?>

    <section style="background: #eef; padding: 10px; margin: 10px 0;">
        <strong>Valor total dos seus serviços: R$ <?= number_format($totalUsuario, 2, ',', '.') ?></strong>
    </section>

    <section style="background: #fee; padding: 10px; margin: 10px 0;">
        <strong>Seus serviços pendentes:</strong>
        <ul>
            <?php foreach ($pendentes as $p): ?>
                <li><?= htmlspecialchars($p['descricao']) ?> — R$ <?= number_format($p['valor'], 2, ',', '.') ?></li>
            <?php endforeach; ?>
            <?php if (empty($pendentes)): ?>
                <li>Nenhum serviço pendente.</li>
            <?php endif; ?>
        </ul>
    </section>

    <a href="/JobsM/public/servicos/novo">+ Novo serviço</a>

    <table border="1" cellpadding="6">
        <tr>
            <th>ID</th><th>Descrição</th><th>Status</th><th>Valor</th><th>Usuário</th><th>Ações</th>
        </tr>
        <?php foreach ($servicos as $s): ?>
        <tr>
            <td><?= htmlspecialchars($s['id']) ?></td>
            <td><?= htmlspecialchars($s['descricao']) ?></td>
            <td><?= htmlspecialchars($s['status']) ?></td>
            <td>R$ <?= number_format($s['valor'], 2, ',', '.') ?></td>
            <td><?= htmlspecialchars($s['usuario_nome']) ?></td>
            <td>
                <a href="/JobsM/public/servicos/editar?id=<?= $s['id'] ?>">Alterar</a>
                <a href="/JobsM/public/servicos/excluir?id=<?= $s['id'] ?>">Excluir</a>
                <?php if ($s['status'] === 'Pendente'): ?>
                    <a href="/JobsM/public/servicos/finalizar?id=<?= $s['id'] ?>">Finalizar</a>
                <?php endif; ?>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>