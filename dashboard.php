<?php
require_once 'includes/auth.php';
requireLogin();
require_once 'includes/db.php';

$sucesso = '';
$erro = '';
$funcionario = null;

// Edição: carregar dados
if (isset($_GET['editar'])) {
    $stmt = $pdo->prepare("SELECT * FROM funcionarios WHERE id = ?");
    $stmt->execute([(int)$_GET['editar']]);
    $funcionario = $stmt->fetch();
}

// Salvar
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id       = (int)($_POST['id'] ?? 0);
    $nome     = trim($_POST['nome'] ?? '');
    $cargo    = trim($_POST['cargo'] ?? '');
    $email    = trim($_POST['email'] ?? '');
    $telefone = trim($_POST['telefone'] ?? '');
    $situacao = $_POST['situacao'] ?? 'Ativo';

    if (!$nome || !$cargo) {
        $erro = 'Nome e Cargo são obrigatórios.';
    } else {
        if ($id > 0) {
            $stmt = $pdo->prepare("UPDATE funcionarios SET nome=?, cargo=?, email=?, telefone=?, situacao=? WHERE id=?");
            $stmt->execute([$nome, $cargo, $email, $telefone, $situacao, $id]);
            $sucesso = 'Funcionário atualizado com sucesso!';
        } else {
            $stmt = $pdo->prepare("INSERT INTO funcionarios (nome, cargo, email, telefone, situacao) VALUES (?,?,?,?,?)");
            $stmt->execute([$nome, $cargo, $email, $telefone, $situacao]);
            $sucesso = 'Funcionário cadastrado com sucesso!';
        }
        $funcionario = null;
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro — Funcionários</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<?php include 'includes/navbar.php'; ?>

<div class="page-container">
    <h2 class="page-title">Cadastro de Funcionários</h2>

    <?php if ($sucesso): ?>
        <div class="alert alert-success"><?= htmlspecialchars($sucesso) ?></div>
    <?php endif; ?>
    <?php if ($erro): ?>
        <div class="alert alert-error"><?= htmlspecialchars($erro) ?></div>
    <?php endif; ?>

    <div class="card">
        <div class="card-title">Cadastro de Funcionários</div>

        <form method="POST" action="dashboard.php">
            <input type="hidden" name="id" value="<?= htmlspecialchars($funcionario['id'] ?? '') ?>">

            <div class="form-grid">
                <!-- Linha 1 -->
                <div class="form-group">
                    <label>ID: Automático</label>
                    <input type="text" placeholder="Nome" name="nome"
                        value="<?= htmlspecialchars($funcionario['nome'] ?? '') ?>" required>
                </div>
                <div class="form-group">
                    <label>Nome</label>
                    <select name="cargo">
                        <?php
                        $cargos = ['Administrador','Gerente','Desenvolvedor','Designer','Analista','Assistente', 'RH','Suporte','Financeiro','Marketing'];
                        $cargoAtual = $funcionario['cargo'] ?? '';
                        foreach ($cargos as $c): ?>
                            <option value="<?= $c ?>" <?= $cargoAtual === $c ? 'selected' : '' ?>><?= $c ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Linha 2 -->
                <div class="form-group">
                    <label>E-mail</label>
                    <input type="email" placeholder="E-mail" name="email"
                        value="<?= htmlspecialchars($funcionario['email'] ?? '') ?>">
                </div>
                <div class="form-group">
                    <label>E-mail (confirmação)</label>
                    <input type="email" placeholder="E-mail">
                </div>

                <!-- Linha 3 -->
                <div class="form-group">
                    <label>Telefone</label>
                    <input type="text" placeholder="Telefone" name="telefone"
                        value="<?= htmlspecialchars($funcionario['telefone'] ?? '') ?>">
                </div>
                <div class="form-group">
                    <label>Situação</label>
                    <div class="radio-group">
                        <label>
                            <input type="radio" name="situacao" value="Ativo"
                                <?= (!isset($funcionario['situacao']) || $funcionario['situacao'] === 'Ativo') ? 'checked' : '' ?>>
                            Ativo
                        </label>
                        <label>
                            <input type="radio" name="situacao" value="Inativo"
                                <?= (isset($funcionario['situacao']) && $funcionario['situacao'] === 'Inativo') ? 'checked' : '' ?>>
                            Inativo
                        </label>
                    </div>
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-save">Salvar</button>
                <button type="reset" class="btn btn-outline">Limpar</button>
                <a href="listagem.php" class="btn btn-outline">Voltar</a>
                <a href="listagem.php" class="btn btn-outline">Fechar</a>
            </div>
        </form>
    </div>
</div>

</body>
</html>