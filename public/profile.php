<?php

if (session_status () === PHP_SESSION_NONE){
    session_start();
}

include_once('../includes/header.php');
include_once('../includes/auth_check.php');

$usuario = $_SESSION['usuario_logueado'];

// Solo ligas creadas por el usuario
$ligas_usuario = $_SESSION['ligas_usuario'] ?? [];
?>

<h2>Perfil de <?= htmlspecialchars($usuario['usuario']); ?></h2>

<p><strong>Email:</strong> <?= htmlspecialchars($usuario['email']); ?></p>
<p><strong>Posición:</strong> <?= htmlspecialchars($usuario['posicion']); ?></p>
<p><strong>Equipo:</strong> <?= htmlspecialchars($usuario['equipo']) ?: 'No especificado'; ?></p>
<p><strong>Género:</strong> <?= htmlspecialchars($usuario['genero']) ?: 'No especificado'; ?></p>
<p><strong>Categoría:</strong> <?= htmlspecialchars($usuario['categoria']); ?></p>
<p><strong>Provincia:</strong> <?= htmlspecialchars($usuario['provincia']) ?: 'No especificada'; ?></p>

<a href="editProfile.php"><button>Editar perfil</button></a>
<a href="logout.php"><button>Cerrar sesión</button></a>

<hr>

<h3>Ligas creadas por ti</h3>

<?php if (!empty($ligas_usuario)): ?>
    <ul>
        <?php foreach ($ligas_usuario as $nombreLiga => $datosLiga): ?>
            <li>
                <strong><?= htmlspecialchars($nombreLiga) ?></strong>
                (<?= htmlspecialchars($datosLiga['categoria'] ?? 'Sin categoría') ?>)
                <a href="leagues.php?liga=<?= urlencode($nombreLiga) ?>">
                    <button style="margin-left:10px;">Ver liga</button>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>
<?php else: ?>
    <p>No has creado ligas todavía.</p>
<?php endif; ?>
