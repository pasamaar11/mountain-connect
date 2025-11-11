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
        ["local"=>"Casetas","visitante"=>"Caspe","resultado"=>"1-0"],
        ["local"=>"Illueca","visitante"=>"Utebo","resultado"=>"0-0"],
        ["local"=>"La Almunia","visitante"=>"Ejea","resultado"=>"1-3"],
        ["local"=>"Tarazona","visitante"=>"Calatayud","resultado"=>"4-2"]
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
