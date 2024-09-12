<?php

session_start();

if ($_SESSION['usuario'] == "") {
    header('Location: ../index.php');
    exit();
}

if ($_SESSION['rol'] != 'admin') {
    header('Location: index.php');
    exit();
}

include_once("../conf/conf.php");

$id = isset($_GET['id']) ? $_GET['id'] : "";

$queryMedicamento = "SELECT * FROM Medicamento WHERE id=".$id;
$resultadoMedicamento = mysqli_query($conexion, $queryMedicamento);
$medicamento = mysqli_fetch_assoc($resultadoMedicamento);

$consultaProveedor = "SELECT nombre FROM Proveedor WHERE id = ".$medicamento['id_proveedor'];
$resultadoProveedor = mysqli_query($conexion, $consultaProveedor);
$proveedor = mysqli_fetch_assoc($resultadoProveedor);

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Eliminar Medicamento</title>
    <style>
        .centered-form {
            max-width: 600px;
            margin: 0 auto;
        }
    </style>
</head>
<body>

<div class="container mt-5">
    <div class="centered-form">
        <h2 class="text-center">Eliminar Medicamento</h2>
        <form action="controles.php" method="POST">
            <div class="form-group">
                <input type="hidden" name="opcion" value="3">
                <input type="hidden" name="id" value="<?php echo $id; ?>">

                <dl class="row border">
                    <dt class="col-4 col-md-3">Nombre</dt>
                    <dd class="col-8 col-md-9">
                        <p class="form-control-static"><?php echo $medicamento['nombre']; ?></p>
                    </dd>
                    <dt class="col-4 col-md-3">Descripción</dt>
                    <dd class="col-8 col-md-9">
                        <p class="form-control-static"><?php echo $medicamento['descripcion']; ?></p>
                    </dd>
                    <dt class="col-4 col-md-3">Precio</dt>
                    <dd class="col-8 col-md-9">
                        <p class="form-control-static"><?php echo $medicamento['precio']; ?></p>
                    </dd>
                    <dt class="col-4 col-md-3">Stock</dt>
                    <dd class="col-8 col-md-9">
                        <p class="form-control-static"><?php echo $medicamento['stock']; ?></p>
                    </dd>
                    <dt class="col-4 col-md-3">Fecha de Expiración</dt>
                    <dd class="col-8 col-md-9">
                        <p class="form-control-static"><?php echo $medicamento['fecha_expiracion']; ?></p>
                    </dd>
                    <dt class="col-4 col-md-3">Proveedor</dt>
                    <dd class="col-8 col-md-9">
                        <p class="form-control-static"><?php echo $proveedor['nombre']; ?></p>
                    </dd>
                </dl>

                <div class="text-center">
                    <button class="btn btn-danger" type="submit">Eliminar</button>
                    <a href="index.php" class="btn btn-secondary">Regresar</a>
                </div>
            </div>
        </form>
    </div>
</div>

</body>
</html>
