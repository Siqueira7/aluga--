
<?php
require_once 'db/db.php';
require_once 'vendor/autoload.php';
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

session_start();
$jwt_secret = 'alugapp_secret_key';
$usuario = null;
$locacoes = [];

if (!empty($_SESSION['jwt'])) {
    try {
        $token = $_SESSION['jwt'];
        $payload = JWT::decode($token, new Key($jwt_secret, 'HS256'));
        $userId = $payload->sub;
        // Busca dados do usuário
        $stmt = $pdo->prepare('SELECT nome, email FROM usuarios WHERE id = ?');
        $stmt->execute([$userId]);
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
        // Busca locações do usuário
        $stmt = $pdo->prepare('SELECT l.*, v.modelo FROM locacoes l JOIN veiculos v ON l.veiculo_id = v.id WHERE l.usuario_id = ? ORDER BY l.data_locacao DESC');
        $stmt->execute([$userId]);
        $locacoes = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
    <title>Perfil | Aluga++</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header>
        <nav class="navbar">
            <div class="logo">Aluga++</div>
            <ul class="nav-links">
                <li><a href="index.php">Início</a></li>
                <li><a href="logout.php">Sair</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <section class="hero">
            <h1>Meu Perfil</h1>
            <p>Veja seus dados e locações realizadas.</p>
        </section>
        <section class="perfil-section">
            <div class="form-card">
                <h2>Dados do Usuário</h2>
                <p><strong>Nome:</strong> <?= htmlspecialchars($usuario['nome']) ?></p>
                <p><strong>E-mail:</strong> <?= htmlspecialchars($usuario['email']) ?></p>
                <a href="edit_user.php" class="btn-alugar">Editar dados</a>
                <a href="change_password.php" class="btn-alugar" style="margin-left:10px;">Alterar senha</a>
            </div>
            <div class="form-card" style="margin-top:2rem;">
                <h2>Minhas Locações</h2>
                <ul class="locacoes-lista">
                    <?php if (count($locacoes) === 0): ?>
                        <li>Nenhuma locação realizada.</li>
                    <?php else: ?>
                        <?php foreach ($locacoes as $loc): ?>
                            <li>
                                Veículo: <?= htmlspecialchars($loc['modelo']) ?> |
                                Valor: R$ <?= number_format($loc['valor'],2,',','.') ?> |
                                Tempo: <?= $loc['tempo'] ?>h |
                                Data: <?= date('d/m/Y H:i', strtotime($loc['data_locacao'])) ?>
                            </li>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </ul>
            </div>
        </section>
    </main>
    <footer>
        <p>&copy; 2025 Aluga++ - Todos os direitos reservados.</p>
    </footer>
</body>
</html>
