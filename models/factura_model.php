<?php

function facturaFechas($db) {
    if (!isset($_POST) || empty($_POST)) {
        require_once("../views/factura_view.php");
    }else {
        $fecha1 = $_POST['fecha1'];
        $fecha2 = $_POST['fecha2'];

        $email = $_SESSION['email'];
        $sql = mysqli_query($db, "SELECT CUSTOMERID FROM CUSTOMER WHERE EMAIL='$email'");
        $row = mysqli_fetch_assoc($sql);
        $idCliente = $row['CUSTOMERID'];
    
        while ($fecha1 <= $fecha2) {
            $sql1 = mysqli_query($db, "SELECT INVOICEID, TOTAL FROM INVOICE WHERE CUSTOMERID='$idCliente' and INVOICEDATE='$fecha1'");
            if ($sql1) {
                while ($row1 = mysqli_fetch_assoc($sql1)) {
                    echo "---------------INICIO DE FACTURA---------------<br>";
                    echo "ID de Factura: ".$row1['INVOICEID']."<br>";
                    echo " Fecha de Factura: ".$fecha1."<br>";
                    echo " Cantidad total: ".$row1['TOTAL']."<br>";
                
                $idFactura = $row1['INVOICEID'];
                $sql2 = mysqli_query($db, "SELECT INVOICELINEID, TRACKID, UNITPRICE FROM INVOICELINE WHERE INVOICEID='$idFactura'");
                if ($sql2) {
                    while ($row2 = mysqli_fetch_assoc($sql2)) {
                            $idCancion = $row2['TRACKID'];
                            $sql3 = mysqli_query($db, "SELECT NAME FROM TRACK WHERE TRACKID='$idCancion'");
                            $row3 = mysqli_fetch_assoc($sql3);
                        echo "---------Canciones de Factura---------<br>";
                        echo "Id Factura de cancion ".$row2['INVOICELINEID']."<br>";
                        echo "Id cancion ".$row2['TRACKID']."<br>";
                        echo "Nombre de la cancion: ".$row3['NAME']."<br>";
                        echo "Precio de cancion ".$row2['UNITPRICE']."<br>";
                    }
                }
                }
            }
    
            $fecha1 = date("Y-m-d",strtotime($fecha1."+ 1 days"));
    
        }
    }
}


?>