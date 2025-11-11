<?php
include_once('../includes/header.php');
include_once('../includes/auth_check.php');

if (!isset($_SESSION)) {
    session_start();
}  

// Inicializar array de comentarios si no existe
if (!isset($_SESSION['comentarios'])) {
    $_SESSION['comentarios'] = [];
}

// Procesar nuevo comentario
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['comentario'], $_POST['partido_id'])) {
    $usuario = $_SESSION['usuario_logueado']['usuario'] ?? 'Anónimo';
    $idPartido = $_POST['partido_id'];
    $texto = trim($_POST['comentario']);
    $fecha = date('Y-m-d H:i');

    $_SESSION['comentarios'][$idPartido][] = [
        'usuario' => $usuario,
        'texto' => $texto,
        'fecha' => $fecha
    ];

    // Evitar reenvío del formulario
    header("Location: " . $_SERVER['PHP_SELF'] . "?liga=" . urlencode($_POST['liga_actual']));
    exit;
}


// Lista de ligas
$ligas = ["Liga 1","Liga 2","Liga 3","Liga 4","Liga 5","Liga 6"];
$ligaSeleccionada = $_POST['liga'] ?? "Liga 1";

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
<tr>
    <th>#</th>
    <th>Local</th>
    <th>Resultado</th>
    <th>Visitante</th>
</tr>
<?php $i=1; foreach($partidos as $p): 
    $idPartido = $p['local'] . "_vs_" . $p['visitante']; // ID único por partido
?>
<tr>
    <td><?= $i++ ?></td>
    <td><?= htmlspecialchars($p["local"]) ?></td>
    <td><strong><?= $p["resultado"] ?></strong></td>
    <td><?= htmlspecialchars($p["visitante"]) ?></td>
</tr>
<tr>
    <td colspan="4">
        <strong>Comentarios:</strong><br>
        <?php
        if (!empty($_SESSION['comentarios'][$idPartido])) {
            foreach ($_SESSION['comentarios'][$idPartido] as $c) {
                echo "<p><strong>" . htmlspecialchars($c['usuario']) . "</strong> (" . $c['fecha'] . "): " . htmlspecialchars($c['texto']) . "</p>";
            }
        } else {
            echo "<p>No hay comentarios aún.</p>";
        }
        ?>
        <form method="post">
            <input type="hidden" name="partido_id" value="<?= $idPartido ?>">
            <input type="hidden" name="liga_actual" value="<?= $ligaSeleccionada ?>">
            <input type="text" name="comentario" placeholder="Escribe un comentario..." required>
            <button type="submit">Enviar</button>
        </form>
    </td>
</tr>
<?php endforeach; ?>
</table>


<p><a href="leagues.php">Ver clasificación</a> | <a href="teams.php">Ver equipos</a></p>
<?php include_once('../includes/footer.php'); ?>
