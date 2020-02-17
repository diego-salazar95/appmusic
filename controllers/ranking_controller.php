<?php
    session_start();

    require_once("../db/conexion.php");

    require_once("../models/ranking_model.php");

    facturaFechasOrden($db);
?>