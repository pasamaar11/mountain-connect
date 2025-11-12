<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


include_once('../includes/header.php');
include_once('../includes/auth_check.php');

// Lista de ligas fijas
$ligasFijas = ["Liga 1","Liga 2","Liga 3","Liga 4","Liga 5","Liga 6"];

// Arrays de equipos fijos
$equiposPorLigaFijas = [
    "Liga 1" => ["Valdefierro","Delicias","Oliver","San José","Casablanca","Montañana","Escalerillas","La Jota"],
    "Liga 2" => ["Casetas","Rosales","Miralbueno","Utebo","La Almozara","Torrero","San Gregorio","San José"],
    "Liga 3" => ["Actur","Oliver","San José","Casablanca","La Jota","Montecanal","Valdefierro","Delicias"],
    "Liga 4" => ["Montañana","Escalerillas","Casetas","Miralbueno","Rosales","San Gregorio","La Almozara","Torrero"],
    "Liga 5" => ["Oliver","Actur","San José","Valdefierro","Casablanca","La Jota","Delicias","Montecanal"],
    "Liga 6" => ["Torrero","La Almozara","Miralbueno","Rosales","Escalerillas","Montañana","San Gregorio","Oliver"]
];

// Combinar con ligas creadas por el usuario
$equiposPorLigaUsuario = $_SESSION['equiposPorLiga'] ?? [];
$equiposPorLiga = array_merge($equiposPorLigaFijas, $equiposPorLigaUsuario);

// Lista completa de ligas
$ligas = array_keys($equiposPorLiga);

// Liga seleccionada
$ligaSeleccionada = $_POST['liga'] ?? $_GET['liga'] ?? "Liga 1";

$equipos = $equiposPorLiga[$ligaSeleccionada] ?? [];
?>

<h2>Equipos de <?= htmlspecialchars($ligaSeleccionada) ?></h2>

<form method="post">
    <label>Selecciona la liga:</label>
    <select name="liga" onchange="this.form.submit()">
        <?php foreach($ligas as $liga): ?>
            <option value="<?= htmlspecialchars($liga) ?>" <?= $liga==$ligaSeleccionada?"selected":"" ?>>
                <?= htmlspecialchars($liga) ?>
            </option>
        <?php endforeach; ?>
    </select>
</form>

<?php if(!empty($equipos)): ?>
<table border="1" cellpadding="8" cellspacing="0">
<tr><th>#</th><th>Equipo</th></tr>
<?php $i=1; foreach($equipos as $e): ?>
<tr><td><?= $i++ ?></td><td><?= htmlspecialchars($e) ?></td></tr>
<?php endforeach; ?>
</table>
<?php else: ?>
<p>No hay equipos registrados para esta liga.</p>
<?php endif; ?>

<p><a href="leagues.php">Ver clasificación</a> | <a href="matches.php">Ver partidos</a></p>
<?php include_once('../includes/footer.php'); ?>
