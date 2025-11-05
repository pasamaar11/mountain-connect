<?php
session_start();
//Eliminamos toda la sesión
$_SESSION = [];
//Destruimos la sesión
session_destroy();
//Redirigimos al login
header("Location: login.php");
exit;
?>
