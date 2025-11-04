<?php include_once('../includes/header.php'); ?>
<?php include_once('../includes/functions.php'); ?>

<h2>Registro de usuario</h2>

<?php
// Inicializamos variables y errores
$errors = [];
$username = $email = $password = $confirm_password = $nivel = $especialidad = $provincia = "";

// Cuando se envía el formulario
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $username = sanitize_input($_POST['username']);
    $email = sanitize_input($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $nivel = sanitize_input($_POST['nivel']);
    $especialidad = sanitize_input($_POST['especialidad']);
    $provincia = sanitize_input($_POST['provincia']);

    // Validaciones
    if (empty($username)) $errors['username'] = "El nombre de usuario es obligatorio.";
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL))
        $errors['email'] = "Introduce un email válido.";
    if (strlen($password) < 6)
        $errors['password'] = "La contraseña debe tener al menos 6 caracteres.";
    if ($password !== $confirm_password)
        $errors['confirm_password'] = "Las contraseñas no coinciden.";
    if (empty($nivel)) $errors['nivel'] = "Selecciona tu nivel de experiencia.";
    if (empty($especialidad)) $errors['especialidad'] = "Selecciona tu especialidad.";
    if (empty($provincia)) $errors['provincia'] = "Selecciona tu provincia.";

    // Si no hay errores
    if (empty($errors)) {
        // Guardado temporal en sesión o array
        session_start();
        $_SESSION['usuarios'][] = [
            'username' => $username,
            'email' => $email,
            'nivel' => $nivel,
            'especialidad' => $especialidad,
            'provincia' => $provincia
        ];
        echo "<p style='color:green;'>Usuario registrado correctamente.</p>";
    }
}
?>

<form method="POST" action="">
    <label>Nombre de usuario:</label><br>
    <input type="text" name="username" value="<?= htmlspecialchars($username) ?>"><br>
    <span style="color:red"><?= $errors['username'] ?? '' ?></span><br>

    <label>Email:</label><br>
    <input type="email" name="email" value="<?= htmlspecialchars($email) ?>"><br>
    <span style="color:red"><?= $errors['email'] ?? '' ?></span><br>

    <label>Contraseña:</label><br>
    <input type="password" name="password"><br>
    <span style="color:red"><?= $errors['password'] ?? '' ?></span><br>

    <label>Confirmar contraseña:</label><br>
    <input type="password" name="confirm_password"><br>
    <span style="color:red"><?= $errors['confirm_password'] ?? '' ?></span><br>

    <label>Nivel de experiencia:</label><br>
    <select name="nivel">
        <option value="">Seleccionar...</option>
        <option value="principiante" <?= $nivel=="principiante"?'selected':'' ?>>Principiante</option>
        <option value="intermedio" <?= $nivel=="intermedio"?'selected':'' ?>>Intermedio</option>
        <option value="avanzado" <?= $nivel=="avanzado"?'selected':'' ?>>Avanzado</option>
    </select><br>
    <span style="color:red"><?= $errors['nivel'] ?? '' ?></span><br>

    <label>Especialidad:</label><br>
    <input type="text" name="especialidad" value="<?= htmlspecialchars($especialidad) ?>"><br>
    <span style="color:red"><?= $errors['especialidad'] ?? '' ?></span><br>

    <label>Provincia:</label><br>
    <input type="text" name="provincia" value="<?= htmlspecialchars($provincia) ?>"><br>
    <span style="color:red"><?= $errors['provincia'] ?? '' ?></span><br>

    <br><input type="submit" value="Registrarse">
</form>

<?php include_once('../includes/footer.php'); ?>
