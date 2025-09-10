
<?php
require_once 'db/db.php';
require_once 'vendor/autoload.php';
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

session_start();
$jwt_secret = 'alugapp_secret_key';
$erro = '';
$veiculos = [];

if (!empty($_SESSION['jwt'])) {
    try {
        $token = $_SESSION['jwt'];
        $payload = JWT::decode($token, new Key($jwt_secret, 'HS256'));
        $userId = $payload->sub;
        // Busca veículos disponíveis
        $stmt = $pdo->query('SELECT * FROM veiculos WHERE disponivel = 1');
        $veiculos = $stmt->fetchAll(PDO::FETCH_ASSOC);
        // Processa locação
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $veiculo_id = intval($_POST['veiculo'] ?? 0);
            $tempo = intval($_POST['tempo'] ?? 0);
            // Busca veículo
            $stmt = $pdo->prepare('SELECT * FROM veiculos WHERE id = ? AND disponivel = 1');
            $stmt->execute([$veiculo_id]);
            $veiculo = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($veiculo && $tempo > 0 && $tempo <= $veiculo['tempo_maximo']) {
                // Registra locação
                $stmt = $pdo->prepare('INSERT INTO locacoes (usuario_id, veiculo_id, valor, tempo) VALUES (?, ?, ?, ?)');
                $stmt->execute([$userId, $veiculo_id, $veiculo['valor'], $tempo]);
                // Marca veículo como indisponível
                $stmt = $pdo->prepare('UPDATE veiculos SET disponivel = 0 WHERE id = ?');
                $stmt->execute([$veiculo_id]);
                header('Location: profile.php');
                exit;
            } else {
                $erro = 'Veículo indisponível ou tempo inválido.';
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
    <title>Locar Veículo | Aluga++</title>
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
            <h1>Locar Veículo</h1>
            <p>Escolha o veículo e defina o tempo de locação.</p>
        </section>
        <section class="form-section">
            <?php if (!empty($erro)): ?>
                <div class="form-card" style="color:#d00; margin-bottom:1rem;"> <?= $erro ?> </div>
            <?php endif; ?>
            <form class="form-card" action="rent.php" method="post">
                <label for="veiculo">Veículo</label>
                <select id="veiculo" name="veiculo" required>
                    <?php foreach ($veiculos as $v): ?>
                        <option value="<?= $v['id'] ?>">
                            <?= htmlspecialchars($v['modelo']) ?> (<?= htmlspecialchars($v['tipo']) ?>) - R$ <?= number_format($v['valor'],2,',','.') ?> | Máx: <?= $v['tempo_maximo'] ?>h
                        </option>
                    <?php endforeach; ?>
                </select>
                <label for="tempo">Tempo de locação (horas)</label>
                <input type="number" id="tempo" name="tempo" min="1" max="<?= !empty($veiculos) ? $veiculos[0]['tempo_maximo'] : 48 ?>" required>
                <button type="submit" class="btn-alugar">Confirmar locação</button>
            </form>
        </section>
    </main>
    <footer>
        <p>&copy; 2025 Aluga++ - Todos os direitos reservados.</p>
    </footer>
</body>
</html>
