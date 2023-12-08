

<?php
include '../componentes/connect.php';
session_start();


?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Producto</title>
</head>
<body>
    <h1>Editar Producto</h1>

    <!-- Formulario con valores por defecto -->
    <form action="procesar_edicion.php" method="post">
        <input type="hidden" name="id" value="<?php echo $id_producto; ?>">

        <label for="nombre">Nombre del producto:</label>
        <input type="text" name="nombre" value="<?php echo $nombre_producto; ?>">

        <label for="precio">Precio del producto:</label>
        <input type="text" name="precio" value="<?php echo $precio_producto; ?>">

        <!-- Otros campos del formulario -->

        <input type="submit" value="Guardar cambios">
    </form>
</body>
</html>

