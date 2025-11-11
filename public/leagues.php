<?php
include_once('../includes/header.php');
include_once('../includes/auth_check.php');

// Lista de ligas
$ligas = [
    "Liga 1" => ["categoria" => "Juvenil"], 
    "Liga 2" => ["categoria" => "Regional"]
];

// Liga seleccionada (por defecto Liga 1)
$ligaSeleccionada = $_POST['liga'] ?? "Liga 1";

// Equipos por liga
$equiposPorLiga = [
    "Liga 1" => ["Valdefierro","Delicias","Escalerillas","Oliver","Pina de Ebro","San José","Casablanca","Montañana"],
    "Liga 2" => ["Casetas","Caspe","Illueca","Utebo","La Almunia","Ejea","Tarazona","Calatayud"]
];

// Partidos por liga
$partidosPorLiga = [
    "Liga 1" => [
        ["local"=>"Valdefierro","visitante"=>"Delicias","resultado"=>"2-1"],
        ["local"=>"Escalerillas","visitante"=>"Oliver","resultado"=>"0-0"],
        ["local"=>"Pina de Ebro","visitante"=>"San José","resultado"=>"1-3"],
        ["local"=>"Casablanca","visitante"=>"Montañana","resultado"=>"4-2"]
    ],
    "Liga 2" => [
        ["local"=>"Casetas","visitante"=>"Caspe","resultado"=>"1-0"],
        ["local"=>"Illueca","visitante"=>"Utebo","resultado"=>"0-0"],
        ["local"=>"La Almunia","visitante"=>"Ejea","resultado"=>"1-3"],
        ["local"=>"Tarazona","visitante"=>"Calatayud","resultado"=>"4-2"]
    ]
];

$equipos = $equiposPorLiga[$ligaSeleccionada];
$partidos = $partidosPorLiga[$ligaSeleccionada];

// Generar clasificación
$tabla = [];
foreach($equipos as $e){
    $tabla[$e] = ["puntos"=>0,"gf"=>0,"gc"=>0,"dg"=>0];
}

foreach($partidos as $p){
    list($golesLocal,$golesVisitante) = explode("-",$p["resultado"]);
    $local = $p["local"];
    $visitante = $p["visitante"];

    $tabla[$local]["gf"] += $golesLocal;
    $tabla[$local]["gc"] += $golesVisitante;

    $tabla[$visitante]["gf"] += $golesVisitante;
    $tabla[$visitante]["gc"] += $golesLocal;

    $tabla[$local]["dg"] = $tabla[$local]["gf"] - $tabla[$local]["gc"];
    $tabla[$visitante]["dg"] = $tabla[$visitante]["gf"] - $tabla[$visitante]["gc"];

    if($golesLocal>$golesVisitante){
        $tabla[$local]["puntos"] += 3;
    } elseif($golesLocal<$golesVisitante){
        $tabla[$visitante]["puntos"] += 3;
    } else {
        $tabla[$local]["puntos"] += 1;
        $tabla[$visitante]["puntos"] += 1;
    }
}

// Ordenar por puntos y diferencia de goles
uasort($tabla,function($a,$b){
    if($a["puntos"] === $b["puntos"]) 
        return $b["dg"] <=> $a["dg"];
    return $b["puntos"] <=> $a["puntos"];
});
?>

<h2>Clasificación <?= htmlspecialchars($ligaSeleccionada) ?></h2>
<p>Categoría de la competición: <?= htmlspecialchars($ligas[$ligaSeleccionada]['categoria']) ?></p>

<form method="post">
    <label>Selecciona la liga:</label>
    <select name="liga" onchange="this.form.submit()">
        <?php foreach($ligas as $nombreLiga => $datosLiga): ?>
    <option value="<?= $nombreLiga ?>" <?= $nombreLiga==$ligaSeleccionada?"selected":"" ?>>
        <?= $nombreLiga ?>
    </option>
<?php endforeach; ?>

    </select>
</form>

<table border="1" cellpadding="8" cellspacing="0">
<tr>
    <th>Pos</th>
    <th>Equipo</th>
    <th>Puntos</th>
    <th>GF</th>
    <th>GC</th>
    <th>DG</th>
</tr>
<?php $pos=1; foreach($tabla as $equipo=>$datos): ?>
<tr>
    <td><?= $pos++ ?></td>
    <td><?= htmlspecialchars($equipo) ?></td>
    <td><?= $datos["puntos"] ?></td>
    <td><?= $datos["gf"] ?></td>
    <td><?= $datos["gc"] ?></td>
    <td><?= $datos["dg"] ?></td>
</tr>
<?php endforeach; ?>
</table>

<p><a href="teams.php">Ver equipos</a> | <a href="matches.php">Ver partidos</a></p>
<?php include_once('../includes/footer.php'); ?>
