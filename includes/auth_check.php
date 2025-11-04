<?php
session_start();
if (!isset($_SESSION['usuario_logueado'])) {
    header("Location: login.php");
    exit;
}
