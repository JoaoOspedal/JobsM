<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Usuários</title>
</head>
<body>
    <h1>Lista de usuários</h1>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>E-mail</th>
        </tr>
        <?php foreach ($usuarios as $usuario): ?>
        <tr>
            <td><?= htmlspecialchars($usuario['id']) ?></td>
            <td><?= htmlspecialchars($usuario['nome']) ?></td>
            <td><?= htmlspecialchars($usuario['email']) ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>