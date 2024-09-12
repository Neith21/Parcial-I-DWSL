<?php

session_start();

if ($_SESSION['usuario'] == "") {
    header('Location: ../index.php');
    exit();
} else {
    header('Location: index.php');
}

include_once("../conf/conf.php");

$nombre = isset($_POST['nombre']) ? $_POST['nombre'] : "";
$descripcion = isset($_POST['descripcion']) ? $_POST['descripcion'] : "";
$precio = isset($_POST['precio']) ? $_POST['precio'] : "";
$stock = isset($_POST['stock']) ? $_POST['stock'] : "";
$fecha_expiracion = isset($_POST['fecha_expiracion']) ? $_POST['fecha_expiracion'] : "";
$id_proveedor = isset($_POST['id_proveedor']) ? $_POST['id_proveedor'] : "";

$opcion = isset($_POST['opcion']) ? $_POST['opcion'] : "";

if ($opcion == 1) {
    $consulta = "INSERT INTO Medicamento (nombre, descripcion, precio, stock, fecha_expiracion, id_proveedor)
                 VALUES ('$nombre', '$descripcion', '$precio', '$stock', '$fecha_expiracion', '$id_proveedor')";
    $ejecutar = mysqli_query($conexion, $consulta);
    retornar_index($ejecutar);

} else if ($opcion == 2) {
    $id = isset($_POST['id']) ? $_POST['id'] : "";
    $consulta = "UPDATE Medicamento SET
                    nombre = '$nombre',
                    descripcion = '$descripcion',
                    precio = '$precio',
                    stock = '$stock',
                    fecha_expiracion = '$fecha_expiracion',
                    id_proveedor = '$id_proveedor'
                 WHERE id = '$id'";
    $ejecutar = mysqli_query($conexion, $consulta);
    retornar_index($ejecutar);

} else if ($opcion == 3) {
    $id = isset($_POST['id']) ? $_POST['id'] : "";
    $consulta = "DELETE FROM Medicamento WHERE id = '$id'";
    $ejecutar = mysqli_query($conexion, $consulta);
    retornar_index($ejecutar);

}

function retornar_index($ejecutar) {
    if ($ejecutar) {
        header('Location: index.php');
    } else {
        echo "Error al realizar la operación.";
    }
}

$conexion->close();

?>
