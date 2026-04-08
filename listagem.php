<?php
require_once 'includes/auth.php';
requireLogin();
require_once 'includes/db.php';

// Delete
if (isset($_GET['excluir'])) {
    $stmt = $pdo->prepare("DELETE FROM funcionarios WHERE id = ?");
    $stmt->execute([(int)$_GET['excluir']]);
    header('Location: listagem.php?msg=excluido');
    exit;
}

// Pagination
$perPage = 5;
$page = max(1, (int)($_GET['page'] ?? 1));
$offset = ($page - 1) * $perPage;

// Search
$busca = trim($_GET['busca'] ?? '');
$where = '';
$params = [];
if ($busca) {
    $where = "WHERE nome ILIKE ? OR cargo ILIKE ? OR email ILIKE ?";
    $params = ["%$busca%", "%$busca%", "%$busca%"];
}

$totalStmt = $pdo->prepare("SELECT COUNT(*) FROM funcionarios $where");
$totalStmt->execute($params);
$total = (int)$totalStmt->fetchColumn();
$totalPages = max(1, ceil($total / $perPage));

$params[] = $perPage;
$params[] = $offset;
$stmt = $pdo->prepare("SELECT * FROM funcionarios $where ORDER BY id LIMIT ? OFFSET ?");
$stmt->execute($params);
$funcionarios = $stmt->fetchAll();

$msg = $_GET['msg'] ?? '';
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listagem — Funcionários</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<?php include 'includes/navbar.php'; ?>

<div class="page-container">
    <h2 class="page-title">Listagem de Funcionários</h2>

    <?php if ($msg === 'excluido'): ?>
        <div class="alert alert-success">Funcionário excluído com sucesso.</div>
    <?php endif; ?>

    <!-- Search bar -->
    <form method="GET" action="listagem.php" class="search-bar">
        <input type="text" name="busca" class="search-input"
               placeholder="Buscar funcionários..." value="<?= htmlspecialchars($busca) ?>">
        <button type="submit" class="btn btn-blue">Pesquisar</button>
        <a href="dashboard.php" class="btn btn-blue">Novo Funcionário</a>
    </form>

    <div class="card" style="padding: 0; overflow: hidden;">
        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nome</th>
                        <th>Cargo</th>
                        <th>E-mail</th>
                        <th>Situação</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($funcionarios): ?>
                        <?php foreach ($funcionarios as $f): ?>
                        <tr>
                            <td><?= $f['id'] ?></td>
                            <td><?= htmlspecialchars($f['nome']) ?></td>
                            <td><?= htmlspecialchars($f['cargo']) ?></td>
                            <td><?= htmlspecialchars($f['email']) ?></td>
                            <td>
                                <span class="badge <?= $f['situacao'] === 'Ativo' ? 'badge-ativo' : 'badge-inativo' ?>">
                                    <?= $f['situacao'] ?>
                                </span>
                            </td>
                            <td>
                                <div class="action-btns">
                                    <a href="dashboard.php?editar=<?= $f['id'] ?>" class="btn-icon edit" title="Editar">&#9998;</a>
                                    <a href="ver.php?id=<?= $f['id'] ?>" class="btn-icon view" title="Ver">&#128196;</a>
                                    <a href="listagem.php?excluir=<?= $f['id'] ?>" class="btn-icon del" title="Excluir"
                                       onclick="return confirm('Confirma a exclusão?')">&#128465;</a>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" style="text-align:center; padding: 32px; color: var(--gray-label);">
                                Nenhum funcionário encontrado.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    <?php if ($totalPages > 1): ?>
    <div class="pagination">
        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
            <a href="listagem.php?page=<?= $i ?>&busca=<?= urlencode($busca) ?>"
               class="page-btn <?= $i === $page ? 'active' : '' ?>"><?= $i ?></a>
        <?php endfor; ?>
        <?php if ($page < $totalPages): ?>
            <a href="listagem.php?page=<?= $page + 1 ?>&busca=<?= urlencode($busca) ?>" class="page-btn">Próximo &raquo;</a>
        <?php endif; ?>
    </div>
    <?php endif; ?>
</div>

</body>
</html>
