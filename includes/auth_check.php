<?php
if(session_status() === PHP_SESSION_NONE){
    session_start();
}
if (!isset($_SESSION['usuario_logueado'])) {
    header("Location: login.php");
    exit;
}
