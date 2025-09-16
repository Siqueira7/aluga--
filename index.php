<?php
session_start();
require_once 'db/db.php';
$logado = !empty($_SESSION['jwt']);

// Buscar veículos disponíveis no banco
$stmt = $pdo->query("SELECT * FROM veiculos WHERE disponivel = 1");
$veiculos = $stmt->fetchAll(PDO::FETCH_ASSOC);

$veiculo_id = isset($_GET['veiculo_id']) ? intval($_GET['veiculo_id']) : null;
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aluga++ | Locação de Veículos</title>
    <link rel="stylesheet" href="css/style.css">
    <?php if (!$logado): ?>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const buttons = document.querySelectorAll('.btn-alugar');
        buttons.forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                alert('Para alugar um veículo, faça login ou cadastre-se!');
            });
        });
    });
    </script>
    <?php endif; ?>
</head>
<body>
    <header>
        <nav class="navbar">
            <div class="logo">Aluga++</div>
            <ul class="nav-links">
                <li><a href="index.php">Início</a></li>
                <?php if (!$logado): ?>
                    <li><a href="login.php">Entrar</a></li>
                    <li><a href="register.php">Cadastrar</a></li>
                <?php else: ?>
                    <li><a href="profile.php">Perfil</a></li>
                    <li><a href="logout.php">Sair</a></li>
                    <?php if (isset($_SESSION['is_admin']) && $_SESSION['is_admin']): ?>
                        <li><a href="admin_veiculos.php" class="btn-admin">Adicionar Veículo</a></li>
                    <?php endif; ?>
                <?php endif; ?>
            </ul>
        </nav>
    </header>
    <main>
        <section class="hero">
            <h1>Encontre o veículo perfeito para você!</h1>
            <p>Alugue carros e motos com facilidade, segurança e rapidez.</p>
        </section>
        <section class="veiculos">
            <h2>Veículos disponíveis</h2>
            <div class="veiculos-lista">
                <?php foreach ($veiculos as $veiculo): ?>
                <div class="card-veiculo">
                    <img src="img/<?php echo htmlspecialchars($veiculo['imagem']); ?>" alt="<?php echo htmlspecialchars($veiculo['modelo']); ?>">
                    <h3><?php echo htmlspecialchars($veiculo['modelo']); ?></h3>
                    <p>Tipo: <?php echo htmlspecialchars($veiculo['tipo']); ?></p>
                    <p>Valor: R$ <?php echo number_format($veiculo['valor'], 2, ',', '.'); ?></p>
                    <p>Tempo máximo: <?php echo htmlspecialchars($veiculo['tempo_maximo']); ?>h</p>
                    <?php if ($logado): ?>
                        <a href="rent.php?veiculo_id=<?php echo $veiculo['id']; ?>" class="btn-alugar">Alugar</a>
                    <?php else: ?>
                        <button class="btn-alugar" data-veiculo="<?php echo $veiculo['id']; ?>">Alugar</button>
                    <?php endif; ?>
                </div>
                <?php endforeach; ?>
            </div>
        </section>
    </main>
    <footer>
        <p>&copy; 2025 Aluga++ - Todos os direitos reservados.</p>
    </footer>
</body>
</html>
