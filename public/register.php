<?php
session_start();
include_once('../includes/header.php');
include_once('../includes/functions.php');

// Si no existe el array de usuarios, lo inicializamos
if (!isset($_SESSION['usuarios'])) {
    $_SESSION['usuarios'] = [];
}

$errores = [];
$usuario = $email = $password = $confirm_password = $posicion = $equipo = $genero = $categoria = $provincia = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // Sanitización de entradas
    $usuario = sanitize_input($_POST['usuario']);
    $email = sanitize_input($_POST['email']);
    $password = $_POST['contraseña'];
    $confirm_password = $_POST['confirmar_contraseña'];
    $posicion = sanitize_input($_POST['posicion']);
    $equipo = sanitize_input($_POST['equipo']);
    $genero = sanitize_input($_POST['genero']);
    $categoria = sanitize_input($_POST['categoria']);
    $provincia = sanitize_input($_POST['provincia']);

    // Validaciones (mensajes de errores)
    if (empty($usuario))
    $errores['usuario'] = "El nombre de usuario es obligatorio.";

if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL))
    $errores['email'] = "Introduce un email válido.";

if (strlen($password) < 6)
    $errores['contraseña'] = "La contraseña debe tener al menos 6 caracteres.";

if ($password !== $confirm_password)
    $errores['confirmar_contraseña'] = "Las contraseñas no coinciden.";


if (empty($posicion))
    $errores['posicion'] = "Selecciona tu posición en el campo.";

if (empty($categoria))
    $errores['categoria'] = "Selecciona tu categoría.";

    // Si no hay errores, registramos el jugador
    if (empty($errores)) {
        $hash = password_hash($password, PASSWORD_DEFAULT);

        $_SESSION['usuarios'][] = [
            'usuario' => $usuario,
            'email' => $email,
            'contraseña' => $hash,
            'posicion' => $posicion,
            'equipo' => $equipo,
            'categoria' => $categoria,
            'genero' => $genero,
            'provincia' => $provincia
        ];

        // Mensaje de éxito en sesión (para mostrar tras redirección)
        $_SESSION['registro_exitoso'] = "Jugador registrado correctamente.";

        // Redirigir para evitar reenvío del formulario
        header("Location: " . $_SERVER['PHP_SELF']);
        exit;
    }
}
?>

<h2>Registro de jugador</h2>

<?php
// Mostrar mensaje de éxito (si existe)
if (isset($_SESSION['registro_exitoso'])) {
    echo "<p style='color:green;'>" . $_SESSION['registro_exitoso'] . "</p>";
    unset($_SESSION['registro_exitoso']);
}
?>

<form method="POST" action="">
    <label>Nombre de usuario:</label><br>
    <input type="text" name="usuario" value="<?= htmlspecialchars($usuario) ?>"><br>
    <span style="color:red"><?= $errores['usuario'] ?? '' ?></span><br/><br/>

    <label>Email:</label><br>
    <input type="email" name="email" value="<?= htmlspecialchars($email) ?>"><br>
    <span style="color:red"><?= $errores['email'] ?? '' ?></span><br/><br/>

    <label>Contraseña:</label><br>
    <input type="password" name="contraseña"><br>
    <span style="color:red"><?= $errores['contraseña'] ?? '' ?></span><br><br/>

    <label>Confirmar contraseña:</label><br>
    <input type="password" name="confirmar_contraseña"><br>
    <span style="color:red"><?= $errores['confirmar_contraseña'] ?? '' ?></span><br><br/>

    <label>Posición en el campo:</label><br>
    <select name="posicion" required>
        <option value="">Seleccionar...</option>
        <option value="Portero" <?= $posicion == "Portero" ? 'selected' : '' ?>>Portero</option>
        <option value="Defensa" <?= $posicion == "Defensa" ? 'selected' : '' ?>>Defensa</option>
        <option value="Centrocampista" <?= $posicion == "Centrocampista" ? 'selected' : '' ?>>Centrocampista</option>
        <option value="Delantero" <?= $posicion == "Delantero" ? 'selected' : '' ?>>Delantero</option>
    </select>
    <span style="color:red"><?= $errores['posicion'] ?? '' ?></span><br><br>

    <label>Equipo Favorito:</label><br>
    <input type="text" name="equipo" value="<?= htmlspecialchars($equipo) ?>"><br>

    <label>Género:</label><br>
    <select name="genero">
        <option value="">Seleccionar...</option>
        <option value="Masculino" <?= $genero == "Masculino" ?>>Masculino</option>
        <option value="Femenino" <?= $genero == "Femenino" ?>>Femenino</option>
    </select><br>

    <label>Categoría:</label><br>
    <select name="categoria" required>
        <option value="">Seleccionar...</option>
        <option value="Regional" <?= $categoria == "Regional" ? 'selected' : ''?>>Regional (+18 años)</option>
        <option value="Juvenil" <?= $categoria == "Juvenil" ? 'selected' : ''?>>Juvenil (16-18 años)</option>
        <option value="Cadete" <?= $categoria == "Cadete" ? 'selected' : ''?>>Cadete (14-15 años)</option>
        <option value="Infantil" <?= $categoria == "Infantil" ? 'selected' : ''?>>Infantil (12-13 años)</option>
        <option value="Alevin" <?= $categoria == "Alevin" ? 'selected' : ''?>>Alevín (10-11 años)</option>
    </select><br>
    <span style="color:red"><?= $errores['categoria'] ?? '' ?></span><br>

    <label>Provincia:</label><br>
    <input type="text" name="provincia" value="<?= htmlspecialchars($provincia) ?>"><br>
    <span style="color:red"><?= $errores['provincia'] ?? '' ?></span><br>

    <br><input type="submit" value="Registrarse">
</form>

<?php
    include_once('../includes/footer.php');
?>
