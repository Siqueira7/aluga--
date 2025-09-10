
<?php
require_once 'db/db.php';
require_once 'vendor/autoload.php';
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

session_start();
$jwt_secret = 'alugapp_secret_key';
$usuario = null;
$erro = '';

if (!empty($_SESSION['jwt'])) {
    try {
        $token = $_SESSION['jwt'];
        $payload = JWT::decode($token, new Key($jwt_secret, 'HS256'));
        $userId = $payload->sub;
        // Busca dados atuais
        $stmt = $pdo->prepare('SELECT nome, email FROM usuarios WHERE id = ?');
        $stmt->execute([$userId]);
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
        // Atualiza dados se enviado
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nome = trim($_POST['nome'] ?? '');
            $email = trim($_POST['email'] ?? '');
            if ($nome && $email) {
                try {
                    $stmt = $pdo->prepare('UPDATE usuarios SET nome = ?, email = ? WHERE id = ?');
                    $stmt->execute([$nome, $email, $userId]);
                    header('Location: profile.php');
                    exit;
                } catch (PDOException $e) {
                    $erro = $e->getCode() == 23000 ? 'E-mail já cadastrado.' : 'Erro ao atualizar.';
                }
            } else {
                $erro = 'Preencha todos os campos.';
            }
            // Atualiza dados exibidos
            $usuario['nome'] = $nome;
            $usuario['email'] = $email;
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
    <title>Editar Dados | Aluga++</title>
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
            <h1>Editar Dados</h1>
            <p>Atualize suas informações cadastrais.</p>
        </section>
        <section class="form-section">
            <?php if (!empty($erro)): ?>
                <div class="form-card" style="color:#d00; margin-bottom:1rem;"> <?= $erro ?> </div>
            <?php endif; ?>
            <form class="form-card" action="edit_user.php" method="post">
                <label for="nome">Nome</label>
                <input type="text" id="nome" name="nome" required value="<?= htmlspecialchars($usuario['nome']) ?>">
                <label for="email">E-mail</label>
                <input type="email" id="email" name="email" required value="<?= htmlspecialchars($usuario['email']) ?>">
                <button type="submit" class="btn-alugar">Salvar alterações</button>
            </form>
        </section>
    </main>
    <footer>
        <p>&copy; 2025 Aluga++ - Todos os direitos reservados.</p>
    </footer>
</body>
</html>
