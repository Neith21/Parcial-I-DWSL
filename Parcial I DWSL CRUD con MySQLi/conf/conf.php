<?php

$servidor = "localhost";
$usuario = "root";
$contrasena = "123123";
$bd = "FarmaciaLasBuenaSS";

$conexion = mysqli_connect($servidor, $usuario, $contrasena, $bd);

if ($conexion) {
    //echo "Conexión exitosa";
} else {
    echo "Conexión fallida";
}

?>