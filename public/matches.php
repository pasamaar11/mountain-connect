<?php
include_once('../includes/header.php');
include_once('../includes/auth_check.php');

// Lista de ligas
$ligas = ["Liga 1","Liga 2"];
$ligaSeleccionada = $_POST['liga'] ?? "Liga 1";

$partidosPorLiga = [
    "Liga 1" => [
        ["local"=>"Valdefierro","visitante"=>"Delicias","resultado"=>"2-1"],
        ["local"=>"Escalerillas","visitante"=>"Oliver","resultado"=>"0-0"],
        ["local"=>"Pina de Ebro","visitante"=>"San José","resultado"=>"1-3"],
        ["local"=>"Casablanca","visitante"=>"Montañana","resultado"=>"4-2"]
    ],
    "Liga 2" => [
        ["local"=>"Equipo A","visitante"=>"Equipo B","resultado"=>"1-0"],
        ["local"=>"Equipo C","visitante"=>"Equipo D","resultado"=>"2-2"]
    ]
];

$partidos = $partidosPorLiga[$ligaSeleccionada];
?>

<h2>Partidos <?= htmlspecialchars($ligaSeleccionada) ?></h2>

<form method="post">
    <label>Selecciona la liga:</label>
    <select name="liga" onchange="this.form.submit()">
        <?php foreach($ligas as $liga): ?>
            <option value="<?= $liga ?>" <?= $liga==$ligaSeleccionada?"selected":"" ?>><?= $liga ?></option>
        <?php endforeach; ?>
    </select>
</form>

<table border="1" cellpadding="8" cellspacing="0">
<tr><th>#</th><th>Local</th><th>Resultado</th><th>Visitante</th></tr>
<?php $i=1; foreach($partidos as $p): ?>
<tr>
    <td><?= $i++ ?></td>
    <td><?= htmlspecialchars($p["local"]) ?></td>
    <td><strong><?= $p["resultado"] ?></strong></td>
    <td><?= htmlspecialchars($p["visitante"]) ?></td>
</tr>
<?php endforeach; ?>
</table>

<p><a href="leagues.php">Ver clasificación</a> | <a href="teams.php">Ver equipos</a></p>
<?php include_once('../includes/footer.php'); ?>
