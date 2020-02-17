<?php
//Llamada a la base de datos
    session_start();
require_once ("../db/conexion.php");

//Llamada al modelo
require_once ("../models/downmusic_model.php");

//Funcion para obtener canciones de 
$canciones = obtenerCancionesDescargar($db);

añadirAlCarrito($db, $canciones);


 
?>