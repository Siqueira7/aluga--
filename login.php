
<?php
require_once 'db/db.php';
require_once 'vendor/autoload.php'; // Biblioteca JWT
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

$jwt_secret = 'alugapp_secret_key'; // Troque por uma chave forte

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $senha = $_POST['senha'] ?? '';
    if ($email && $senha) {
        $stmt = $pdo->prepare('SELECT * FROM usuarios WHERE email = ?');
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($user && password_verify($senha, $user['senha'])) {
            // Gera token JWT
            $payload = [
                'sub' => $user['id'],
                'email' => $user['email'],
                'nome' => $user['nome'],
                'iat' => time(),
                'exp' => time() + 3600
            ];
            $token = JWT::encode($payload, $jwt_secret, 'HS256');
            // Salva token no banco
            $stmt = $pdo->prepare('UPDATE usuarios SET token_jwt = ? WHERE id = ?');
            $stmt->execute([$token, $user['id']]);
            // Salva token na sessão
            session_start();
            $_SESSION['jwt'] = $token;
            header('Location: profile.php');
            exit;
        } else {
            $erro = 'E-mail ou senha inválidos.';
        }
    } else {
        $erro = 'Preencha todos os campos.';
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Aluga++</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header>
        <nav class="navbar">
            <div class="logo">Aluga++</div>
            <ul class="nav-links">
                <li><a href="index.php">Início</a></li>
                <li><a href="register.php">Cadastrar</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <section class="hero">
            <h1>Entrar no sistema</h1>
            <p>Informe seu e-mail e senha para acessar.</p>
        </section>
        <section class="form-section">
            <?php if (!empty($erro)): ?>
                <div class="form-card" style="color:#d00; margin-bottom:1rem;"> <?= $erro ?> </div>
            <?php endif; ?>
            <form class="form-card" action="login.php" method="post">
                <label for="email">E-mail</label>
                <input type="email" id="email" name="email" required>
                <label for="senha">Senha</label>
                <input type="password" id="senha" name="senha" required>
                <button type="submit" class="btn-alugar">Entrar</button>
            </form>
        </section>
    </main>
    <footer>
        <p>&copy; 2025 Aluga++ - Todos os direitos reservados.</p>
    </footer>
</body>
</html>
