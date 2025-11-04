<?php include_once('../includes/header.php'); ?>
<?php include_once('../includes/functions.php'); ?>

<h2>Registro de jugador</h2>

<?php
$errores = [];
$usuario = $email = $contraseña = $confirmar_contraseña = $posicion = $equipo = $provincia = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $usuario = sanitize_input($_POST['usuario']);
    $email = sanitize_input($_POST['email']);
    $contraseña = $_POST['contraseña'];
    $confirmar_contraseña = $_POST['confirmar_contraseña'];
    $posicion = sanitize_input($_POST['posicion']);
    $equipo = sanitize_input($_POST['equipo']);
    $provincia = sanitize_input($_POST['provincia']);

    // Validaciones
    if (empty($usuario)) $errores['usuario'] = "El nombre de usuario es obligatorio.";
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL))
        $errores['email'] = "Introduce un email válido.";
    if (strlen($contraseña) < 6)
        $errores['contraseña'] = "La contraseña debe tener al menos 6 caracteres.";
    if ($contraseña !== $confirmar_contraseña)
        $errores['confirmar_contraseña'] = "Las contraseñas no coinciden.";
    if (empty($posicion)) $errores['posicion'] = "Selecciona tu posición en el campo.";
    if (empty($equipo)) $errores['equipo'] = "Indica tu equipo actual o favorito.";
    if (empty($provincia)) $errores['provincia'] = "Selecciona tu provincia.";

    // Si no hay errores
    if (empty($errores)) {
        session_start();
        $_SESSION['usuarios'][] = [
            'usuario' => $usuario,
            'email' => $email,
            'posicion' => $posicion,
            'equipo' => $equipo,
            'provincia' => $provincia
        ];
        echo "<p style='color:green;'>Jugador registrado correctamente.</p>";
    }
}
?>

<form method="POST" action="">
    <label>Nombre de usuario:</label><br>
    <input type="text" name="usuario" value="<?= htmlspecialchars($usuario) ?>"><br>
    <span style="color:red"><?= $errores['usuario'] ?? '' ?></span><br>

    <label>Email:</label><br>
    <input type="email" name="email" value="<?= htmlspecialchars($email) ?>"><br>
    <span style="color:red"><?= $errores['email'] ?? '' ?></span><br>

    <label>Contraseña:</label><br>
    <input type="password" name="contraseña"><br>
    <span style="color:red"><?= $errores['contraseña'] ?? '' ?></span><br>

    <label>Confirmar contraseña:</label><br>
    <input type="password" name="confirmar_contraseña"><br>
    <span style="color:red"><?= $errores['confirmar_contraseña'] ?? '' ?></span><br>

    <label>Posición en el campo:</label><br>
    <select name="posicion">
        <option value="">Seleccionar...</option>
        <option value="portero" <?= $posicion=="portero"?'selected':'' ?>>Portero</option>
        <option value="defensa" <?= $posicion=="defensa"?'selected':'' ?>>Defensa</option>
        <option value="centrocampista" <?= $posicion=="centrocampista"?'selected':'' ?>>Centrocampista</option>
        <option value="delantero" <?= $posicion=="delantero"?'selected':'' ?>>Delantero</option>
    </select><br>
    <span style="color:red"><?= $errores['posicion'] ?? '' ?></span><br>

    <label>Equipo Favorito:</label><br>
    <input type="text" name="equipo" value="<?= htmlspecialchars($equipo) ?>"><br>
    <span style="color:red"><?= $errores['equipo'] ?? '' ?></span><br>

    <label>Provincia:</label><br>
    <input type="text" name="provincia" value="<?= htmlspecialchars($provincia) ?>"><br>
    <span style="color:red"><?= $errores['provincia'] ?? '' ?></span><br>

    <br><input type="submit" value="Registrarse">
</form>

<?php
session_start();
if (!empty($_SESSION['usuarios'])) {
    echo "<h3>Jugadores registrados:</h3><pre>";
    print_r($_SESSION['usuarios']);
    echo "</pre>";
}
?>

<?php include_once('../includes/footer.php'); ?>
