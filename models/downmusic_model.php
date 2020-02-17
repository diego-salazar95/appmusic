<?php
    require_once("../db/conexion.php");

//Funcion para obtener todas las canciones que puede descargar
function obtenerCancionesDescargar($db) {
    $canciones = array();
    
    $sql = mysqli_query($db, "SELECT NAME FROM TRACK");
    if($sql) {
        while ($row = mysqli_fetch_assoc($sql)) {
            $canciones[] = $row['NAME'];
        }
    }
    return $canciones;
}

//Funcion que añade al carrito realiza comprobaciones y hace la compra
function añadirAlCarrito($db, $canciones) {
    //Comprobacion de botod de realizar Compra
    if (!isset($_POST['boton_realizar']) || empty($_POST['boton_realizar'])) {
        if (!isset($_POST['boton_descargar']) || empty($_POST['boton_descargar']) && !isset($_POST['cancion']) || empty($_POST['cancion'])) {
            //Eligiendo Canciones
            require_once("../views/downmusic_view.php");
        }else {
            //Añadir cancion a las descargas
            $cancion = $_POST['cancion'];
            $carrito = $_SESSION['carrito'];

            if (!in_array($cancion, $carrito)) {
                array_push($carrito, $cancion);
            }
            require_once("../views/downmusic_view.php");

            var_dump($carrito);
        }
    }else {
        //Accion de descargar
        require_once("../views/downmusic2_view.php");
        $carrito = $_SESSION['carrito'];
        if (empty($carrito)) {
            echo "<h1> You have not added any song </h1>";
        }else {
            $preciosCanciones = finalizarCompra($db, $carrito);
            $total = mostrarFactura($carrito, $preciosCanciones);
            $maximoInvoiceId = factura($db, $total);
            facturaLine($db, $maximoInvoiceId);
            borrarCarrito($carrito);
        }
    }
}

function borrarCarrito($carrito) {
    unset($carrito);
    $carrito = array();
    $_SESSION['carrito'] = $carrito;
}

function finalizarCompra($db, $carrito) {
    $preciosCanciones = array();
    foreach ($carrito as $can) {
        $sql = mysqli_query($db, "SELECT UNITPRICE FROM TRACK WHERE NAME='$can'");
        $row = mysqli_fetch_assoc($sql);
        $preciosCanciones[] = $row['UNITPRICE'];
    }

    return $preciosCanciones;
}

function mostrarFactura($carrito, $preciosCanciones) {
    $total = 0;
    echo "<h1> Factura </h1>";
    for ($i=0; $i < count($carrito); $i++) { 
        echo "<strong>Cancion: </strong>". $carrito[$i] ."<strong> Precio: </strong>".$preciosCanciones[$i]."<br>";
        $total = $total + $preciosCanciones[$i];
    }

    echo "<h2> Precio total del pedido $total </h2>";
    return $total;
}

function factura($db, $total) {
    $email = $_SESSION['email'];
    
    //Fecha actual del sistema
    $fechaActual = gmdate("Y-m-d");

    //Sacar invoiceID
    $sqlInvoice = mysqli_query($db, "SELECT max(INVOICEID) as a FROM INVOICE");
    $rowInvoice = mysqli_fetch_assoc($sqlInvoice);
    $maximoInvoiceId = $rowInvoice['a'];
    $maximoInvoiceId++;

    //Saca los datos de los clientes
    $sql = mysqli_query($db, "SELECT CUSTOMERID, ADDRESS, CITY,STATE, COUNTRY, POSTALCODE FROM CUSTOMER WHERE EMAIL='$email'");
    $row = mysqli_fetch_assoc($sql);
    $customerid =  $row['CUSTOMERID'];
    $vAddress =  $row['ADDRESS'];
    $vCity =  $row['CITY'];
    $vState =  $row['STATE'];
    $vCountry =  $row['COUNTRY'];
    $vPostalCode = $row['POSTALCODE'];

    $añadir = "INSERT INTO INVOICE(INVOICEID, CUSTOMERID, INVOICEDATE, BILLINGADDRESS, 
    BILLINGCITY, BILLINGSTATE, BILLINGCOUNTRY, BILLINGPOSTALCODE, TOTAL)
    values ('$maximoInvoiceId','$customerid','$fechaActual','$vAddress', '$vCity',
    '$vState','$vCountry','$vPostalCode','$total')";

    $db -> query($añadir);

    return $maximoInvoiceId;
}

function facturaLine($db, $maximoInvoiceId) {

    $carrito = $_SESSION['carrito'];

    foreach ($carrito as $key) {
        //Maximo invoice line id
        $sqlInvoiceLine = mysqli_query($db, "SELECT max(INVOICELINEID) as a FROM INVOICELINE");
        $rowInvoiceLine = mysqli_fetch_assoc($sqlInvoiceLine);
        $maximoInvoiceLineId = $rowInvoiceLine['a'];
        $maximoInvoiceLineId++;

        //Trackid
        $sqlTrackId = mysqli_query($db, "SELECT TRACKID, UNITPRICE FROM TRACK WHERE NAME='$key'");
        $rowTrackId = mysqli_fetch_assoc($sqlTrackId);
        $trackId =  $rowTrackId['TRACKID'];
        $preciosCanciones = $rowTrackId['UNITPRICE'];

        //Cantidad de veces descargada
        $sqlDescargas = mysqli_query($db, "SELECT QUANTITY FROM INVOICELINE WHERE TRACKID='$trackId'");
        $rowDescargas = mysqli_fetch_assoc($sqlDescargas);
        $cantidadDescargas = $rowDescargas['QUANTITY'];
        $cantidadDescargas++;

        $añadir = "INSERT INTO INVOICELINE(INVOICELINEID, INVOICEID,TRACKID, UNITPRICE, QUANTITY)
        VALUES ('$maximoInvoiceLineId','$maximoInvoiceId','$trackId','$preciosCanciones','$cantidadDescargas')";
        $db -> query($añadir);
    }
}

?>