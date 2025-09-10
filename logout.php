
<?php
session_start();
session_unset();
session_destroy();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logout | Aluga++</title>
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
            <h1>Logout</h1>
            <p>Você saiu do sistema.</p>
            <a href="login.php" class="btn-alugar">Entrar novamente</a>
        </section>
    </main>
    <footer>
        <p>&copy; 2025 Aluga++ - Todos os direitos reservados.</p>
    </footer>
</body>
</html>
