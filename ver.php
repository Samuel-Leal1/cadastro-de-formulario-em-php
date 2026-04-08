<?php
require_once 'includes/auth.php';
requireLogin();
require_once 'includes/db.php';

$stmt = $pdo->prepare("SELECT * FROM funcionarios WHERE id = ?");
$stmt->execute([(int)($_GET['id'] ?? 0)]);
$f = $stmt->fetch();

if (!$f) {
    header('Location: listagem.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalhes — Funcionário</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<?php include 'includes/navbar.php'; ?>

<div class="page-container">
    <h2 class="page-title">Detalhes do Funcionário</h2>
    <div class="card">
        <div class="card-title">Funcionário #<?= $f['id'] ?></div>
        <div class="form-grid">
            <div class="form-group">
                <label>Nome</label>
                <input type="text" value="<?= htmlspecialchars($f['nome']) ?>" readonly>
            </div>
            <div class="form-group">
                <label>Cargo</label>
                <input type="text" value="<?= htmlspecialchars($f['cargo']) ?>" readonly>
            </div>
            <div class="form-group">
                <label>E-mail</label>
                <input type="text" value="<?= htmlspecialchars($f['email']) ?>" readonly>
            </div>
            <div class="form-group">
                <label>Telefone</label>
                <input type="text" value="<?= htmlspecialchars($f['telefone']) ?>" readonly>
            </div>
            <div class="form-group">
                <label>Situação</label>
                <input type="text" value="<?= htmlspecialchars($f['situacao']) ?>" readonly>
            </div>
        </div>
        <div class="form-actions">
            <a href="dashboard.php?editar=<?= $f['id'] ?>" class="btn btn-save">Editar</a>
            <a href="listagem.php" class="btn btn-outline">Voltar</a>
        </div>
    </div>
</div>

</body>
</html>