<?php
    include_once('../includes/header.php');
    include_once('../includes/auth_check.php');
    include_once('../includes/data.php');

    //Si se envió el formulario
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $nombre = trim($_POST['nombre']);
        $categoria = trim($_POST['categoria']);

        if($nombre !== "" && $categoria !== ""){
            //Guardamos la liga
            $_SESSION['ligas'][] = [
                "nombre" => $nombre,
                "categoria" => $categoria
            ];
            // Crear arrays vacíos asociados a la liga
            $_SESSION['equiposPorLiga'][$nombre] = [];
            $_SESSION['partidosPorLiga'][$nombre] = [];

            $mensaje = "Liga creada correctamente ✅";
        } else {
        $mensaje = "Rellena todos los campos ❌";
    }
}
?>
<h2>Crear Nueva Liga</h2>
<?php if(isset($mensaje)) echo "<p>$mensaje</p>"; ?>
    <form method = post>
        <label>Nombre de la liga:</label><br>
        <input type="text" name="nombre" required><br><br>
        <label>Categoría:</label><br>
        <select name="categoria" required>
            <option value="">Seleccionar...</option>
            <option value="Regional">Regional (+18 años)</option>
            <option value="Juvenil">Juvenil (16-18 años)</option>
            <option value="Cadete">Cadete (14-15 años)</option>
            <option value="Infantil">Infantil (12-13 años)</option>
        </select><br><br>
        <input type="submit" value="Crear Liga">
        </form>

        <p><a href="leagues.php">Volver a Ligas</a></p>
        <?php include_once('../includes/footer.php'); ?>
        }
    }