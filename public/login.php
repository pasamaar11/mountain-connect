<?php include_once('../includes/header.php'); ?>
<?php include_once('../includes/functions.php'); ?>

<h2>Iniciar sesión</h2>

<?php
session_start();
$errores = [];
$usuario = $contraseña = "";

// Si se envía el formulario
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Sanitización de entradas
    $usuario = sanitize_input($_POST['usuario']);
    $contraseña = $_POST['contraseña'];

    if (empty($usuario)) $errores['usuario'] = "Introduce tu nombre de usuario.";
    if (empty($contraseña)) $errores['contraseña'] = "Introduce tu contraseña.";

    // Si no hay errores
    if (empty($errores)) {
        // Comprobamos si hay usuarios en sesión (temporal)
        if (!empty($_SESSION['usuarios'])) {
            $usuario_encontrado = null;

            foreach ($_SESSION['usuarios'] as $u) {
                if ($u['usuario'] === $usuario) {
                    $usuario_encontrado = $u;
                    break;
                }
            }

            if ($usuario_encontrado) {
                // Verificamos la contraseña
                if (password_verify($contraseña, $usuario_encontrado['contraseña'])) {
                    $_SESSION['usuario_logueado'] = $usuario_encontrado;
                    header("Location: profile.php");
                    exit;
                } else {
                    $errores['general'] = "Contraseña incorrecta.";
                }
            } else {
                $errores['general'] = "Usuario no encontrado. Regístrate primero.";
            }
        } else {
            $errores['general'] = "No hay usuarios registrados. Regístrate primero.";
        }
    }
}
?>

<form method="POST" action="">
    <label>Nombre de usuario:</label><br>
    <input type="text" name="usuario" value="<?= htmlspecialchars($usuario) ?>"><br>
    <span style="color:red"><?= $errores['usuario'] ?? '' ?></span><br>

    <label>Contraseña:</label><br>
    <input type="password" name="contraseña"><br>
    <span style="color:red"><?= $errores['contraseña'] ?? '' ?></span><br>

    <br><input type="submit" value="Entrar">
</form>

<?php if (isset($errores['general'])): ?>
    <p style="color:red;"><?= $errores['general'] ?></p>
<?php endif; ?>

<p>¿Aún no tienes cuenta? <a href="register.php">Regístrate aquí</a></p>

<?php include_once('../includes/footer.php'); ?>
