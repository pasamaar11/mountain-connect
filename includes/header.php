<?php
// Iniciar sesión solo si aún no está activa
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FootballConnect</title>
    <link rel="stylesheet" href="/PHP/mountain-connect/assets/css/styles.css">
</head>
<body>
    <header class="nav-header">
        <nav class="nav-container">
            <div class="logo-container">
                <h1 class="logo">FootballConnect</h1>
            </div>

            <ul class="nav-links">
                <a href="/PHP/mountain-connect/public/index.php" class="nav-btn">🏠 Inicio</a>

                <?php if (isset($_SESSION['usuario_logueado'])): ?>
                    <a href="/PHP/mountain-connect/public/profile.php" class="nav-btn">
                        👤 <?= htmlspecialchars($_SESSION['usuario_logueado']['usuario']) ?>
                    </a>
                    <a href= "/PHP/mountain-connect/public/logout.php" class="nav-btn">💔 Cerrar sesión</a>
                <?php else: ?>
                    <a href="/PHP/mountain-connect/public/login.php" class="nav-btn">Login</a>
                    <a href="/PHP/mountain-connect/public/register.php" class="nav-btn">Registro</a>
                <?php endif; ?>
            </ul>
        </nav>
    </header>
    <main>
