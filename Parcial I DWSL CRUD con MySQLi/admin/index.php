<?php

session_start();

if ($_SESSION['usuario'] == "") {
    header('Location: ../index.php');
    exit();
}

include_once("../conf/conf.php");

if (isset($_POST['buscar'])) {
    $busqueda = mysqli_real_escape_string($conexion, $_POST['busqueda']);
    $consulta = "SELECT medicamento.id, medicamento.nombre, medicamento.descripcion, medicamento.precio, medicamento.stock, medicamento.fecha_expiracion, proveedor.nombre AS proveedor
                 FROM medicamento
                 LEFT JOIN proveedor ON medicamento.id_proveedor = proveedor.id
                 WHERE medicamento.nombre LIKE '%$busqueda%' 
                    OR medicamento.descripcion LIKE '%$busqueda%'
                    OR medicamento.precio LIKE '%$busqueda%'
                    OR medicamento.stock LIKE '%$busqueda%'
                    OR medicamento.fecha_expiracion LIKE '%$busqueda%'
                    OR proveedor.nombre LIKE '%$busqueda%'";
} else {
    $consulta = "SELECT medicamento.id, medicamento.nombre, medicamento.descripcion, medicamento.precio, medicamento.stock, medicamento.fecha_expiracion, proveedor.nombre AS proveedor
                 FROM medicamento
                 LEFT JOIN proveedor ON medicamento.id_proveedor = proveedor.id";
}

$ejecutar = mysqli_query($conexion, $consulta);

?>


<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../resources/index.css">
    <title>Index</title>
</head>

<body>
    <!-- Menu -->
    <nav id="slide-menu">
        <ul>
            <li><a class="navbar-brand" href="#">
                    <i class="bi bi-person-circle"></i>
                    <?php echo "Bienvenido " . $_SESSION['usuario']; ?>
                </a></li>
            <li>Dashboard</li>
            <li>Profile</li>
            <li>Settings</li>
            <li>
                <a class="nav-link" href="./salir.php">Salir</a>
            </li>
        </ul>
    </nav>
    <!-- Content -->
    <div id="content">
        <div class="menu-trigger"></div>
        <h1>Side Bar Menu</h1>
        <br><br>
        <div class="container">
            <h1 class="text-center">Gestión de Medicamentos</h1>
            <form action="" method="POST" class="d-flex mb-4">
                <input class="form-control me-2" type="search" name="busqueda" placeholder="Buscar por nombre, descripción, precio, stock, fecha de expiración o proveedor" aria-label="Buscar">
                <button class="btn btn-outline-success" type="submit" name="buscar">Buscar</button>
            </form>

            <?php if ($_SESSION["rol"] == 'admin'): ?>
                <a href="medicamentoRegistro.php" class="btn btn-success mb-3">Agregar Medicamento</a>
            <?php endif; ?>

            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Precio</th>
                        <th>Stock</th>
                        <th>Fecha de Expiración</th>
                        <th>Proveedor</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php

                    while ($data = mysqli_fetch_assoc($ejecutar)) {
                        echo "<tr>";
                        echo "<td>" . $data['id'] . "</td>";
                        echo "<td>" . $data['nombre'] . "</td>";
                        echo "<td>" . $data['descripcion'] . "</td>";
                        echo "<td>" . $data['precio'] . "</td>";
                        echo "<td>" . $data['stock'] . "</td>";
                        echo "<td>" . $data['fecha_expiracion'] . "</td>";
                        echo "<td>" . $data['proveedor'] . "</td>";
                        echo '<td><a href="medicamentoEdicion.php?id=' . $data['id'] . '" class="btn btn-primary">Editar</a> ';
                        if ($_SESSION["rol"] == 'admin') {
                            echo '<a href="medicamentoEliminar.php?id=' . $data['id'] . '" class="btn btn-danger">Eliminar</a>';
                        }
                        echo "</tr>";
                    }

                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <script src="../resources/index.js"></script>
</body>

</html>