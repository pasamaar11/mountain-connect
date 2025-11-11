<?php
    if(session_status() === PHP_SESSION_NONE){
        session_start();
    }

//Si no existe la liga, se crea vacia
if(!isset($_SESSION['ligas'])){
    $_SESSION['lifas'] = [];
}

//Si no existe la lista de equipos por liga se crea
if(!isset($_SESSION['equiposPorLiga'])){
    $_SESSION['equiposPorLiga'] = [];
}

//Si no existe la lista de partidos por liga se crea
if(!isset($_SESSION['partidosPorLiga'])){
    $_SESSION['partidosPorLiga'] = [];
}