<?php
require_once 'includes/auth.php';

if (isLoggedIn()) {
    header('Location: listagem.php');
    exit;
}

$erro = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once 'includes/db.php';
    $usuario = trim($_POST['usuario'] ?? '');
    $senha = $_POST['senha'] ?? '';

    if ($usuario && $senha) {
        $stmt = $pdo->prepare("SELECT id, nome, senha FROM usuarios WHERE usuario = ?");
        $stmt->execute([$usuario]);
        $user = $stmt->fetch();

        if ($user && password_verify($senha, $user['senha'])) {
            $_SESSION['usuario_id'] = $user['id'];
            $_SESSION['usuario_nome'] = $user['nome'];
            header('Location: listagem.php');
            exit;
        } else {
            $erro = 'Usuário ou senha inválidos.';
        }
    } else {
        $erro = 'Preencha todos os campos.';
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — Cadastro de Funcionários</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<div class="login-page">
    <div class="login-box">
        <h1 class="login-title">Cadastro de Funcionários</h1>

        <?php if ($erro): ?>
            <div class="login-error"><?= htmlspecialchars($erro) ?></div>
        <?php endif; ?>

        <form method="POST" action="index.php">
            <div class="input-group">
                <span class="input-icon">&#128100;</span>
                <input type="text" name="usuario" placeholder="Usuário" required autocomplete="username">
            </div>
            <div class="input-group">
                <span class="input-icon">&#128274;</span>
                <input type="password" name="senha" placeholder="Senha" required autocomplete="current-password">
            </div>
            <button type="submit" class="btn-primary">Entrar</button>
        </form>

        <hr class="login-divider">
       <a class="forgot-link" href="forgot.php">Esqueci minha senha</a>
    </div>
</div>
</body>
</html>
