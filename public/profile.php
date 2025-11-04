<?php
include_once('../includes/header.php');
include_once('../includes/auth_check.php');

$usuario = $_SESSION['usuario_logueado'];
?>

<h2>Perfil de <?= htmlspecialchars($usuario['usuario']); ?> ⚽</h2>

<p><strong>Email:</strong> <?= htmlspecialchars($usuario['email']); ?></p>
<p><strong>Posición:</strong> <?= htmlspecialchars($usuario['posicion'] ?? 'No especificada'); ?></p>
<p><strong>Equipo:</strong> <?= htmlspecialchars($usuario['equipo'] ?? 'No especificado'); ?></p>
<p><strong>Provincia:</strong> <?= htmlspecialchars($usuario['provincia']); ?></p>

<a href="logout.php">Cerrar sesión</a>

<?php include_once('../includes/footer.php'); ?>
