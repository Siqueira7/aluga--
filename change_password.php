
<?php
require_once 'db/db.php';
require_once 'vendor/autoload.php';
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

session_start();
$jwt_secret = 'alugapp_secret_key';
$erro = '';

if (!empty($_SESSION['jwt'])) {
    try {
        $token = $_SESSION['jwt'];
        $payload = JWT::decode($token, new Key($jwt_secret, 'HS256'));
        $userId = $payload->sub;
        // Busca senha atual
        $stmt = $pdo->prepare('SELECT senha FROM usuarios WHERE id = ?');
        $stmt->execute([$userId]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $senha_atual = $_POST['senha_atual'] ?? '';
            $nova_senha = $_POST['nova_senha'] ?? '';
            if ($senha_atual && $nova_senha) {
                if (password_verify($senha_atual, $user['senha'])) {
                    $novaHash = password_hash($nova_senha, PASSWORD_DEFAULT);
                    $stmt = $pdo->prepare('UPDATE usuarios SET senha = ? WHERE id = ?');
                    $stmt->execute([$novaHash, $userId]);
                    header('Location: profile.php');
                    exit;
                } else {
                    $erro = 'Senha atual incorreta.';
                }
            } else {
                $erro = 'Preencha todos os campos.';
            }
        }
    } catch (Exception $e) {
        header('Location: login.php');
        exit;
    }
} else {
    header('Location: login.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alterar Senha | Aluga++</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header>
        <nav class="navbar">
            <div class="logo">Aluga++</div>
            <ul class="nav-links">
                <li><a href="index.php">Início</a></li>
                <li><a href="profile.php">Perfil</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <section class="hero">
            <h1>Alterar Senha</h1>
            <p>Digite sua nova senha abaixo.</p>
        </section>
        <section class="form-section">
            <?php if (!empty($erro)): ?>
                <div class="form-card" style="color:#d00; margin-bottom:1rem;"> <?= $erro ?> </div>
            <?php endif; ?>
            <form class="form-card" action="change_password.php" method="post">
                <label for="senha_atual">Senha atual</label>
                <input type="password" id="senha_atual" name="senha_atual" required>
                <label for="nova_senha">Nova senha</label>
                <input type="password" id="nova_senha" name="nova_senha" required>
                <button type="submit" class="btn-alugar">Alterar senha</button>
            </form>
        </section>
    </main>
    <footer>
        <p>&copy; 2025 Aluga++ - Todos os direitos reservados.</p>
    </footer>
</body>
</html>
