<?php
    session_start();

// Modelo contiene la lógica de la aplicación: clases y métodos que se comunican
// con la Base de Datos

function entrar($db) {
    if (!isset($_POST) || empty($_POST)) {
        require_once ("views/login_view.php");
    }else {
    //Recoger variables y ponerlas en mayusculas
    $vEmail = $_POST['email'];
    $vPassword = $_POST['password'];

    //Todos los usuarios $arrayUsuarios
    $arrayUsers = obtenerUsuario($db);

    //Guardamos variables de sesion
    $_SESSION['email_sesion'] = $vEmail;

    if (!in_array($vEmail, $arrayUsers)) {
        die("El usuario no se encuentra registrado");
    }else {
            $contraseña = obtenerContraseña($db, $vEmail);
        if ($vPassword === $contraseña) {
            $carrito = [];
            $_SESSION['carrito'] = $carrito;
            $_SESSION['email'] = $vEmail;
            header ("location: views/inicio_view.php");
        }else {
            die("Contraseña incorrecta");
        }
    }   
}
}

function obtenerUsuario($db) {
    $arrayUsuarios = array();
    
    $sql = mysqli_query($db, "SELECT EMAIL FROM CUSTOMER");
    if ($sql) {
        while($row = mysqli_fetch_assoc($sql)) {
            $arrayUsuarios[] = $row['EMAIL'];
        }
    }
    return $arrayUsuarios;
}

//OBtenemos contraseña
function obtenerContraseña($db, $vEmail) {
    $sql = mysqli_query($db, "SELECT LASTNAME FROM CUSTOMER WHERE EMAIL = '$vEmail'");
    if ($sql) {
        while($row = mysqli_fetch_assoc($sql)) {
            $contraseña = $row['LASTNAME'];
        }
    }
    return $contraseña;
}
?>