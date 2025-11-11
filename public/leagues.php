<?php
include_once('../includes/header.php');
include_once('../includes/auth_check.php');

// Lista de ligas
$ligas = [
    "Liga 1" => ["categoria" => "Juvenil"], 
    "Liga 2" => ["categoria" => "Regional"],
    "Liga 3" => ["categoria" => "Alevín"],
    "Liga 4" => ["categoria" => "Infantil"],
    "Liga 5" => ["categoria" => "Juvenil Femenino"],
    "Liga 6" => ["categoria" => "Regional Femenino"]
];

// Liga seleccionada (por defecto Liga 1)
$ligaSeleccionada = $_POST['liga'] ?? "Liga 1";

// Equipos por liga
$equiposPorLiga = [
    "Liga 1" => ["Valdefierro","Delicias","Oliver","San José","Casablanca","Montañana","Escalerillas","La Jota"],
    "Liga 2" => ["Casetas","Rosales","Miralbueno","Utebo","La Almozara","Torrero","San Gregorio","San José"],
    "Liga 3" => ["Actur","Oliver","San José","Casablanca","La Jota","Montecanal","Valdefierro","Delicias"],
    "Liga 4" => ["Montañana","Escalerillas","Casetas","Miralbueno","Rosales","San Gregorio","La Almozara","Torrero"],
    "Liga 5" => ["Oliver","Actur","San José","Valdefierro","Casablanca","La Jota","Delicias","Montecanal"],
    "Liga 6" => ["Torrero","La Almozara","Miralbueno","Rosales","Escalerillas","Montañana","San Gregorio","Oliver"]
];


// Partidos por liga
$partidosPorLiga = [
    "Liga 1" => [
        ["local"=>"Valdefierro","visitante"=>"Delicias","resultado"=>"2-1"],
        ["local"=>"Oliver","visitante"=>"San José","resultado"=>"1-1"],
        ["local"=>"Casablanca","visitante"=>"Montañana","resultado"=>"3-2"],
        ["local"=>"Escalerillas","visitante"=>"La Jota","resultado"=>"0-0"],
        ["local"=>"Delicias","visitante"=>"Oliver","resultado"=>"1-2"],
        ["local"=>"San José","visitante"=>"Valdefierro","resultado"=>"0-3"],
        ["local"=>"Montañana","visitante"=>"Escalerillas","resultado"=>"2-2"],
        ["local"=>"La Jota","visitante"=>"Casablanca","resultado"=>"1-1"]
    ],

    "Liga 2" => [
        ["local"=>"Casetas","visitante"=>"Rosales","resultado"=>"2-0"],
        ["local"=>"Miralbueno","visitante"=>"Utebo","resultado"=>"1-1"],
        ["local"=>"La Almozara","visitante"=>"Torrero","resultado"=>"0-3"],
        ["local"=>"San Gregorio","visitante"=>"San José","resultado"=>"1-2"],
        ["local"=>"Rosales","visitante"=>"Miralbueno","resultado"=>"2-2"],
        ["local"=>"Utebo","visitante"=>"Casetas","resultado"=>"1-1"],
        ["local"=>"Torrero","visitante"=>"San Gregorio","resultado"=>"3-0"],
        ["local"=>"San José","visitante"=>"La Almozara","resultado"=>"2-1"]
    ],

    "Liga 3" => [
        ["local"=>"Actur","visitante"=>"Oliver","resultado"=>"0-2"],
        ["local"=>"San José","visitante"=>"Casablanca","resultado"=>"1-1"],
        ["local"=>"La Jota","visitante"=>"Montecanal","resultado"=>"3-1"],
        ["local"=>"Valdefierro","visitante"=>"Delicias","resultado"=>"2-2"],
        ["local"=>"Oliver","visitante"=>"San José","resultado"=>"1-0"],
        ["local"=>"Casablanca","visitante"=>"Actur","resultado"=>"2-2"],
        ["local"=>"Montecanal","visitante"=>"La Jota","resultado"=>"0-1"],
        ["local"=>"Delicias","visitante"=>"Valdefierro","resultado"=>"1-3"]
    ],

    "Liga 4" => [
        ["local"=>"Montañana","visitante"=>"Escalerillas","resultado"=>"2-2"],
        ["local"=>"Casetas","visitante"=>"Miralbueno","resultado"=>"1-1"],
        ["local"=>"Rosales","visitante"=>"San Gregorio","resultado"=>"0-3"],
        ["local"=>"La Almozara","visitante"=>"Torrero","resultado"=>"2-2"],
        ["local"=>"Escalerillas","visitante"=>"Montañana","resultado"=>"1-2"],
        ["local"=>"Miralbueno","visitante"=>"Rosales","resultado"=>"2-0"],
        ["local"=>"San Gregorio","visitante"=>"La Almozara","resultado"=>"1-1"],
        ["local"=>"Torrero","visitante"=>"Casetas","resultado"=>"3-1"]
    ],

    "Liga 5" => [
        ["local"=>"Oliver","visitante"=>"Actur","resultado"=>"1-0"],
        ["local"=>"San José","visitante"=>"Valdefierro","resultado"=>"0-2"],
        ["local"=>"Casablanca","visitante"=>"La Jota","resultado"=>"2-1"],
        ["local"=>"Delicias","visitante"=>"Montecanal","resultado"=>"1-1"],
        ["local"=>"Actur","visitante"=>"San José","resultado"=>"1-2"],
        ["local"=>"Valdefierro","visitante"=>"Oliver","resultado"=>"3-1"],
        ["local"=>"Montecanal","visitante"=>"Casablanca","resultado"=>"0-2"],
        ["local"=>"La Jota","visitante"=>"Delicias","resultado"=>"1-1"]
    ],

    "Liga 6" => [
        ["local"=>"Torrero","visitante"=>"La Almozara","resultado"=>"2-1"],
        ["local"=>"Miralbueno","visitante"=>"Rosales","resultado"=>"0-0"],
        ["local"=>"Escalerillas","visitante"=>"Montañana","resultado"=>"1-3"],
        ["local"=>"San Gregorio","visitante"=>"Oliver","resultado"=>"1-2"],
        ["local"=>"La Almozara","visitante"=>"Miralbueno","resultado"=>"2-2"],
        ["local"=>"Rosales","visitante"=>"Torrero","resultado"=>"1-1"],
        ["local"=>"Montañana","visitante"=>"San Gregorio","resultado"=>"3-0"],
        ["local"=>"Oliver","visitante"=>"Escalerillas","resultado"=>"2-2"]
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
