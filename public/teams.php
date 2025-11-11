<?php
include_once('../includes/header.php');
include_once('../includes/auth_check.php');

// Lista de ligas
$ligas = ["Liga 1","Liga 2"];
$ligaSeleccionada = $_POST['liga'] ?? "Liga 1";

$equiposPorLiga = [
    "Liga 1" => ["Valdefierro","Delicias","Escalerillas","Oliver","Pina de Ebro","San José","Casablanca","Montañana"],
    "Liga 2" => ["Casetas","Caspe","Illueca","Utebo","La Almunia","Ejea","Tarazona","Calatayud"]
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
