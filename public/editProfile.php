<?php
include_once('../includes/header.php');
include_once('../includes/auth_check.php');

$usuario = $_SESSION['usuario_logueado'];

// Procesar formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $_SESSION['usuario_logueado']['email'] = $_POST['email'];
    $_SESSION['usuario_logueado']['posicion'] = $_POST['posicion'];
    $_SESSION['usuario_logueado']['equipo'] = $_POST['equipo'];
    $_SESSION['usuario_logueado']['genero'] = $_POST['genero'];
    $_SESSION['usuario_logueado']['categoria'] = $_POST['categoria'];
    $_SESSION['usuario_logueado']['provincia'] = $_POST['provincia'];

    $success = "Perfil actualizado correctamente!";
    $usuario = $_SESSION['usuario_logueado']; // refrescar datos
}
?>

<h2>Editar Perfil de <?= htmlspecialchars($usuario['usuario']); ?></h2>

<?php 
if (isset($success)) {
    echo "<p class='success'>$success</p>";
}
?>

<form method="post">

    <label>Email:</label>
    <input type="email" name="email" value="<?= htmlspecialchars($usuario['email']); ?>" required>

    <label>Posición en el campo:</label><br>
    <select name="posicion">
        <option value="">Seleccionar...</option>
        <option value="Portero" <?= $usuario['posicion'] == "Portero" ? 'selected' : '' ?>>Portero</option>
        <option value="Defensa" <?= $usuario['posicion'] == "Defensa" ? 'selected' : '' ?>>Defensa</option>
        <option value="Centrocampista" <?= $usuario['posicion'] == "Centrocampista" ? 'selected' : '' ?>>Centrocampista</option>
        <option value="Delantero" <?= $usuario['posicion'] == "Delantero" ? 'selected' : '' ?>>Delantero</option>
    </select><br>

    <label>Equipo:</label>
    <input type="text" name="equipo" value="<?= htmlspecialchars($usuario['equipo']); ?>">

    <label>Género:</label><br>
    <select name="genero">
        <option value="">Seleccionar...</option>
        <option value="Masculino" <?= $usuario['genero'] == "Masculino" ? 'selected' : '' ?>>Masculino</option>
        <option value="Femenino" <?= $usuario['genero'] == "Femenino" ? 'selected' : '' ?>>Femenino</option>
    </select><br>

    <label>Categoría:</label><br>
    <select name="categoria">
        <option value="">Seleccionar...</option>
        <option value="Regional" <?= $usuario['categoria'] == "Regional" ? 'selected' : '' ?>>Regional (+18 años)</option>
        <option value="Juvenil" <?= $usuario['categoria'] == "Juvenil" ? 'selected' : '' ?>>Juvenil (16-18 años)</option>
        <option value="Cadete" <?= $usuario['categoria'] == "Cadete" ? 'selected' : '' ?>>Cadete (14-15 años)</option>
        <option value="Infantil" <?= $usuario['categoria'] == "Infantil" ? 'selected' : '' ?>>Infantil (12-13 años)</option>
        <option value="Alevin" <?= $usuario['categoria'] == "Alevin" ? 'selected' : '' ?>>Alevín (10-11 años)</option>
    </select><br>

    <label>Provincia:</label>
    <input type="text" name="provincia" value="<?= htmlspecialchars($usuario['provincia']); ?>">

    <button type="submit">Guardar cambios</button>
</form>

<p><a href="profile.php">Volver al perfil</a></p>

<?php include_once('../includes/footer.php'); ?>
