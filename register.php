<?php
require_once 'db/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = trim($_POST['nome'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $senha = $_POST['senha'] ?? '';

    if ($nome && $email && $senha) {
        $senhaHash = password_hash($senha, PASSWORD_DEFAULT);
        try {
            $is_admin = false; // Sempre falso para cadastro público
            $stmt = $pdo->prepare("INSERT INTO usuarios (nome, email, senha, is_admin) VALUES (?, ?, ?, ?)");
            $stmt->execute([$nome, $email, $senhaHash, $is_admin]);
            header('Location: login.php?cadastro=ok');
            exit;
        } catch (PDOException $e) {
            $erro = $e->getCode() == 23000 ? 'E-mail já cadastrado.' : 'Erro ao cadastrar.';
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
    <title>Cadastro | Aluga++</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header>
        <nav class="navbar">
            <div class="logo">Aluga++</div>
            <ul class="nav-links">
                <li><a href="index.php">Início</a></li>
                <li><a href="login.php">Entrar</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <section class="hero">
            <h1>Crie sua conta</h1>
            <p>Preencha os dados abaixo para se cadastrar.</p>
        </section>
        <section class="form-section">
            <?php if (!empty($erro)): ?>
                <div class="form-card" style="color:#d00; margin-bottom:1rem;"> <?= $erro ?> </div>
            <?php endif; ?>
            <form class="form-card" action="register.php" method="post">
                <label for="nome">Nome</label>
                <input type="text" id="nome" name="nome" required>
                <label for="email">E-mail</label>
                <input type="email" id="email" name="email" required>
                <label for="senha">Senha</label>
                <input type="password" id="senha" name="senha" required>
                <button type="submit" class="btn-alugar">Cadastrar</button>
            </form>
        </section>
    </main>
    <footer>
        <p>&copy; 2025 Aluga++ - Todos os direitos reservados.</p>
    </footer>
</body>
</html>
