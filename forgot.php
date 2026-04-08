<?php
$msg = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $msg = 'Se o usuário existir, um link de recuperação foi enviado.';
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperar senha</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<div class="login-page">
    <div class="login-box">
        <h1 class="login-title">Recuperar senha</h1>

        <?php if ($msg): ?>
            <div class="alert alert-success"><?= $msg ?></div>
        <?php endif; ?>

        <form method="POST">
            <div class="input-group">
                <span class="input-icon">&#128100;</span>
                <input type="text" name="usuario" placeholder="Usuário" required>
            </div>

            <button type="submit" class="btn-primary">Enviar link</button>
        </form>

        <hr class="login-divider">
        <a class="forgot-link" href="index.php">Voltar ao login</a>
    </div>
</div>
</body>
</html>
