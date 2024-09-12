<?php

session_start();

if ($_SESSION['usuario'] == "") {
    header('Location: ../index.php');
    exit();
}

include_once("../conf/conf.php");

$id = isset($_GET['id']) ? $_GET['id'] : "";

$queryMedicamento = "SELECT * FROM Medicamento WHERE id = $id";
$resultadoMedicamento = mysqli_query($conexion, $queryMedicamento);
$medicamento = mysqli_fetch_assoc($resultadoMedicamento);

$consultaProveedores = "SELECT id, nombre FROM Proveedor";
$resultadoProveedores = mysqli_query($conexion, $consultaProveedores);

$rol = $_SESSION['rol'];

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Edición de Medicamento</title>
    <style>
        .readonly {
            background-color: lightgray;
        }
    </style>
</head>

<body>
    <div class="container mt-5">
        <h2>Editar Medicamento</h2>
        <form action="controles.php" method="POST">
            <input type="text" name="opcion" value="2" hidden>
            <input type="text" name="id" value="<?php echo $id; ?>" hidden>

            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre</label>
                <input type="text" class="form-control <?php echo ($rol === 'vendedor') ? 'readonly' : ''; ?>" name="nombre" value="<?php echo $medicamento['nombre']; ?>" 
                <?php echo ($rol === 'vendedor') ? 'readonly' : ''; ?> required>
            </div>

            <div class="mb-3">
                <label for="descripcion" class="form-label">Descripción</label>
                <textarea class="form-control <?php echo ($rol === 'vendedor') ? 'readonly' : ''; ?>" name="descripcion" <?php echo ($rol === 'vendedor') ? 'readonly' : ''; ?> required><?php echo $medicamento['descripcion']; ?></textarea>
            </div>

            <div class="mb-3">
                <label for="precio" class="form-label">Precio</label>
                <input type="number" class="form-control <?php echo ($rol === 'vendedor') ? 'readonly' : ''; ?>" name="precio" value="<?php echo $medicamento['precio']; ?>" step="0.01" 
                <?php echo ($rol === 'vendedor') ? 'readonly' : ''; ?> required>
            </div>

            <div class="mb-3">
                <label for="stock" class="form-label">Stock</label>
                <input type="number" class="form-control" name="stock" value="<?php echo $medicamento['stock']; ?>" required>
            </div>

            <div class="mb-3">
                <label for="fecha_expiracion" class="form-label">Fecha de Expiración</label>
                <input type="date" class="form-control <?php echo ($rol === 'vendedor') ? 'readonly' : ''; ?>" name="fecha_expiracion" value="<?php echo $medicamento['fecha_expiracion']; ?>" 
                <?php echo ($rol === 'vendedor') ? 'readonly' : ''; ?> required>
            </div>

            <div class="mb-3">
                <label for="id_proveedor" class="form-label">Proveedor</label>
                <?php if ($rol === 'vendedor') { ?>
                    <input type="text" class="form-control readonly" value="<?php echo $medicamento['id_proveedor']; ?>" readonly>
                    <input type="hidden" name="id_proveedor" value="<?php echo $medicamento['id_proveedor']; ?>">
                <?php } else { ?>
                    <select class="form-select" name="id_proveedor" required>
                        <option value="">Selecciona un proveedor</option>
                        <?php while ($proveedor = mysqli_fetch_assoc($resultadoProveedores)) { ?>
                            <option value="<?php echo $proveedor['id']; ?>" <?php echo ($proveedor['id'] == $medicamento['id_proveedor']) ? 'selected' : ''; ?>>
                                <?php echo $proveedor['nombre']; ?>
                            </option>
                        <?php } ?>
                    </select>
                <?php } ?>
            </div>

            <button type="submit" class="btn btn-primary">Actualizar Medicamento</button>
            <a href="index.php" class="btn btn-secondary">Regresar</a>
        </form>
    </div>
</body>

</html>