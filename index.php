
<?php
session_start();
$logado = !empty($_SESSION['jwt']);
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
                <!-- Card Honda CG 160 -->
                <div class="card-veiculo">
                    <img src="img/honda-cg160.jpg" alt="Honda CG 160">
                    <h3>Honda CG 160</h3>
                    <p>Tipo: Moto</p>
                    <p>Valor: R$ 80,00</p>
                    <p>Tempo máximo: 24h</p>
                    <?php if ($logado): ?>
                        <a href="rent.php" class="btn-alugar">Alugar</a>
                    <?php else: ?>
                        <button class="btn-alugar">Alugar</button>
                    <?php endif; ?>
                </div>
                <!-- Card Fiat Uno -->
                <div class="card-veiculo">
                    <img src="img/fiat-uno.jpg" alt="Fiat Uno">
                    <h3>Fiat Uno</h3>
                    <p>Tipo: Carro</p>
                    <p>Valor: R$ 120,00</p>
                    <p>Tempo máximo: 48h</p>
                    <?php if ($logado): ?>
                        <a href="rent.php" class="btn-alugar">Alugar</a>
                    <?php else: ?>
                        <button class="btn-alugar">Alugar</button>
                    <?php endif; ?>
                </div>
                <!-- Card Yamaha Fazer -->
                <div class="card-veiculo">
                    <img src="img/yamaha-fazer.jpg" alt="Yamaha Fazer">
                    <h3>Yamaha Fazer</h3>
                    <p>Tipo: Moto</p>
                    <p>Valor: R$ 90,00</p>
                    <p>Tempo máximo: 24h</p>
                    <?php if ($logado): ?>
                        <a href="rent.php" class="btn-alugar">Alugar</a>
                    <?php else: ?>
                        <button class="btn-alugar">Alugar</button>
                    <?php endif; ?>
                </div>
                <!-- Card Volkswagen Gol -->
                <div class="card-veiculo">
                    <img src="img/vw-gol.jpg" alt="Volkswagen Gol">
                    <h3>Volkswagen Gol</h3>
                    <p>Tipo: Carro</p>
                    <p>Valor: R$ 130,00</p>
                    <p>Tempo máximo: 48h</p>
                    <?php if ($logado): ?>
                        <a href="rent.php" class="btn-alugar">Alugar</a>
                    <?php else: ?>
                        <button class="btn-alugar">Alugar</button>
                    <?php endif; ?>
                </div>
            </div>
        </section>
    </main>
    <footer>
        <p>&copy; 2025 Aluga++ - Todos os direitos reservados.</p>
    </footer>
</body>
</html>
