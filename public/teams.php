<?php
include_once('../includes/header.php');
include_once('../includes/auth_check.php');

// Lista de ligas
$ligas = ["Liga 1","Liga 2","Liga 3","Liga 4","Liga 5","Liga 6"];
$ligaSeleccionada = $_POST['liga'] ?? "Liga 1";

$equiposPorLiga = [
    "Liga 1" => ["Valdefierro","Delicias","Oliver","San José","Casablanca","Montañana","Escalerillas","La Jota"],
    "Liga 2" => ["Casetas","Rosales","Miralbueno","Utebo","La Almozara","Torrero","San Gregorio","San José"],
    "Liga 3" => ["Actur","Oliver","San José","Casablanca","La Jota","Montecanal","Valdefierro","Delicias"],
    "Liga 4" => ["Montañana","Escalerillas","Casetas","Miralbueno","Rosales","San Gregorio","La Almozara","Torrero"],
    "Liga 5" => ["Oliver","Actur","San José","Valdefierro","Casablanca","La Jota","Delicias","Montecanal"],
    "Liga 6" => ["Torrero","La Almozara","Miralbueno","Rosales","Escalerillas","Montañana","San Gregorio","Oliver"]
];

$equipos = $equiposPorLiga[$ligaSeleccionada];
?>

<h2>Equipos <?= htmlspecialchars($ligaSeleccionada) ?></h2>

<form method="post">
    <label>Selecciona la liga:</label>
    <select name="liga" onchange="this.form.submit()">
        <?php foreach($ligas as $liga): ?>
            <option value="<?= $liga ?>" <?= $liga==$ligaSeleccionada?"selected":"" ?>><?= $liga ?></option>
        <?php endforeach; ?>
    </select>
</form>

<table border="1" cellpadding="8" cellspacing="0">
<tr><th>#</th><th>Equipo</th></tr>
<?php $i=1; foreach($equipos as $e): ?>
<tr><td><?= $i++ ?></td><td><?= htmlspecialchars($e) ?></td></tr>
<?php endforeach; ?>
</table>

<p><a href="leagues.php">Ver clasificación</a> | <a href="matches.php">Ver partidos</a></p>
<?php include_once('../includes/footer.php'); ?>
