<?php
session_start();
require_once 'db/db.php';

// Verifica se está logado e é admin
if (!isset($_SESSION['usuario_id']) || !$_SESSION['is_admin']) {
    header('Location: login.php');
    exit;
}

$msg = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $modelo = $_POST['modelo'];
    $tipo = $_POST['tipo'];
    $valor = $_POST['valor'];
    $tempo_maximo = $_POST['tempo_maximo'];
    $imagem_nome = '';

    if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] == 0) {
        $imagem_nome = uniqid() . '_' . $_FILES['imagem']['name'];
        move_uploaded_file($_FILES['imagem']['tmp_name'], 'img/' . $imagem_nome);
    }

    $stmt = $pdo->prepare("INSERT INTO veiculos (modelo, tipo, valor, tempo_maximo, disponivel, imagem) VALUES (?, ?, ?, ?, 1, ?)");
    $stmt->execute([$modelo, $tipo, $valor, $tempo_maximo, $imagem_nome]);
    $msg = "Veículo cadastrado com sucesso!";
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel Admin | Adicionar Veículo</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header>
        <nav class="navbar">
            <div class="logo">Aluga++</div>
            <ul class="nav-links">
                <li><a href="index.php">Início</a></li>
                <li><a href="profile.php">Perfil</a></li>
                <li><a href="admin_veiculos.php" class="btn-admin">Adicionar Veículo</a></li>
                <li><a href="logout.php">Sair</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <section class="hero">
            <h1>Adicionar Veículo</h1>
            <p>Cadastre novos veículos para locação.</p>
        </section>
        <section class="form-section">
            <?php if ($msg): ?>
                <div class="form-card" style="color: #080; margin-bottom: 1rem;"><?= $msg ?></div>
            <?php endif; ?>
            <form class="form-card" method="post" enctype="multipart/form-data">
                <label for="modelo">Modelo</label>
                <input type="text" id="modelo" name="modelo" required>
                <label for="tipo">Tipo</label>
                <select id="tipo" name="tipo" required>
                    <option value="Carro">Carro</option>
                    <option value="Moto">Moto</option>
                </select>
                <label for="valor">Valor (R$)</label>
                <input type="number" id="valor" name="valor" step="0.01" required>
                <label for="tempo_maximo">Tempo máximo (horas)</label>
                <input type="number" id="tempo_maximo" name="tempo_maximo" min="1" required>
                <label for="imagem">Foto do veículo</label>
                <input type="file" id="imagem" name="imagem" accept="image/*" required>
                <button type="submit" class="btn-alugar">Cadastrar Veículo</button>
            </form>
        </section>
    </main>
    <footer>
        <p>&copy; 2025 Aluga++ - Todos os direitos reservados.</p>
    </footer>
</body>
</html>