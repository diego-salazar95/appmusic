<?php
    session_start();

    require_once("../db/conexion.php");

    require_once("../models/factura_model.php");

    facturaFechas($db);


?>