<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link rel="stylesheet" href="/JobsM/public/assets/css/style.css">
</head>
<body style="margin: 0;">
    <div class="dashboard-layout">
        <aside class="sidebar">
            <div class="sidebar-user">
                Logado como:<br>
                <?= htmlspecialchars($_SESSION['usuario_nome']) ?> (<?= htmlspecialchars($_SESSION['usuario_email']) ?>)
            </div>
            <nav class="sidebar-nav">
                <a href="/JobsM/public/servicos/novo">Cadastrar Serviço</a>
                <a href="/JobsM/public/logout">Sair</a>
            </nav>
        </aside>

        <main class="dashboard-content">
            <h1 class="dashboard-title">Dashboard</h1>

            <?php if (isset($_SESSION['sucesso'])): ?>
                <p style="color: green;"><?= htmlspecialchars($_SESSION['sucesso']) ?></p>
                <?php unset($_SESSION['sucesso']); ?>
            <?php endif; ?>
            <?php if (isset($_SESSION['erro'])): ?>
                <p style="color: red;"><?= htmlspecialchars($_SESSION['erro']) ?></p>
                <?php unset($_SESSION['erro']); ?>
            <?php endif; ?>

            <div class="dashboard-columns">
                <div class="dashboard-column">
                    <h2 class="dashboard-column-title">Valor total dos seus serviços</h2>
                    <p>R$ <?= number_format($totalUsuario, 2, ',', '.') ?></p>
                </div>

                <div class="dashboard-column">
                    <h2 class="dashboard-column-title">Serviços Pendentes</h2>
                    <ul>
                        <?php foreach ($pendentes as $p): ?>
                            <li><?= htmlspecialchars($p['descricao']) ?> — R$ <?= number_format($p['valor'], 2, ',', '.') ?></li>
                        <?php endforeach; ?>
                        <?php if (empty($pendentes)): ?>
                            <li>Nenhum serviço pendente.</li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>

            <form class="filter-form" action="/JobsM/public/dashboard" method="GET">
                <label>De: <input class="filter-box" type="date" name="data_inicio" value="<?= htmlspecialchars($filtros['data_inicio']) ?>"></label>
                <label>Até: <input class="filter-box" type="date" name="data_fim" value="<?= htmlspecialchars($filtros['data_fim']) ?>"></label>
                <input class="filter-box" type="text" name="descricao" placeholder="Serviço" value="<?= htmlspecialchars($filtros['descricao']) ?>">
                <select class="filter-box" name="status">
                    <option value="">Status</option>
                    <option value="Pendente" <?= $filtros['status'] === 'Pendente' ? 'selected' : '' ?>>Pendente</option>
                    <option value="Finalizado" <?= $filtros['status'] === 'Finalizado' ? 'selected' : '' ?>>Finalizado</option>
                </select>
                <input class="filter-box" type="text" name="usuario_nome" placeholder="Usuário" value="<?= htmlspecialchars($filtros['usuario_nome']) ?>">
                <button type="submit" class="bottons">Filtrar</button>
                <a class="bottons bottons--md" href="/JobsM/public/dashboard">Limpar</a>
            </form>

            <table class="servicos-table">
                <tr>
                    <th>ID</th><th>Descrição</th><th>Status</th><th>Valor</th><th>Usuário</th><th class="table-actions-col"></th>
                </tr>
                <?php foreach ($servicos as $s): ?>
                <tr>
                    <td><?= htmlspecialchars($s['id']) ?></td>
                    <td><?= htmlspecialchars($s['descricao']) ?></td>
                    <td><?= htmlspecialchars($s['status']) ?></td>
                    <td>R$ <?= number_format($s['valor'], 2, ',', '.') ?></td>
                    <td><?= htmlspecialchars($s['usuario_nome']) ?></td>
                    <td class="table-actions-col table-actions">
                        <a class="bottons bottons--sm" href="/JobsM/public/servicos/editar?id=<?= $s['id'] ?>">Alterar</a>
                        <a class="bottons bottons--sm" href="/JobsM/public/servicos/excluir?id=<?= $s['id'] ?>" data-confirmar="Tem certeza que quer excluir este serviço?">Excluir</a>
                        <?php if ($s['status'] === 'Pendente'): ?>
                            <a class="bottons bottons--sm" href="/JobsM/public/servicos/finalizar?id=<?= $s['id'] ?>" data-confirmar="Finalizar este serviço? Essa ação não pode ser desfeita.">Finalizar</a>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </table>
        </main>
    </div>

    <script src="/JobsM/public/assets/js/app.js"></script>
</body>
</html>
