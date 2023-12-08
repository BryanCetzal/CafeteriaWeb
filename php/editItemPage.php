<?php
// ...

if (isset($_GET['id']) && isset($_GET['type']) && isset($_GET['data'])) {
    $itemId = $_GET['id'];
    $itemType = $_GET['type'];
    $itemData = json_decode($_GET['data'], true);

    // Mostrar el formulario según el tipo de item
    if ($itemType === 'coffee') {
        $milkOptions = array('Entera', 'Deslactosada', 'Ninguno');
        $sizeOptions = array('Chico', 'Mediano', 'Grande');
        
        echo '<div class="container mt-4">';
        echo '  <h2>Editar Café</h2>';
        echo '  <form id="editCoffeeForm">';
        echo '    <div class="form-group">';
        echo '      <label for="milktype">Tipo de Leche:</label>';
        echo '      <select id="milktype" name="milktype" class="form-control" required>';
        
        // Opciones dinámicas para el tipo de leche
        foreach ($milkOptions as $option) {
            echo '        <option value="' . $option . '" ' . ($itemData['milktype'] === $option ? 'selected' : '') . '>' . $option . '</option>';
        }
        
        echo '      </select>';
        echo '    </div>';
        echo '    <div class="form-group">';
        echo '      <label for="size">Tamaño:</label>';
        echo '      <select id="size" name="size" class="form-control" required>';
        
        // Opciones dinámicas para el tamaño
        foreach ($sizeOptions as $option) {
            echo '        <option value="' . $option . '" ' . ($itemData['size'] === $option ? 'selected' : '') . '>' . $option . '</option>';
        }
        
        echo '      </select>';
        echo '    </div>';
        echo '    <div class="form-group">';
        echo '      <label for="quantity">Cantidad:</label>';
        echo '      <input type="number" id="quantity" name="quantity" value="' . $itemData['quantity'] . '" class="form-control" required>';
        echo '    </div>';
    } elseif ($itemType === 'additional_dessert') {
        echo '<div class="container mt-4">';
        echo '  <h2>Editar Postre o Adicional</h2>';
        echo '  <form id="editAdditionalDessertForm">';
        echo '    <div class="form-group">';
        echo '      <label for="quantity">Cantidad:</label>';
        echo '      <input type="number" id="quantity" name="quantity" value="' . $itemData['quantity'] . '" class="form-control" required>';
        echo '    </div>';
    }
    
    // Agregar campos ocultos para pasar información al procesar el formulario
    echo '    <input type="hidden" id="itemId" name="itemId" value="' . $itemId . '">';
    echo '    <input type="hidden" id="itemType" name="itemType" value="' . $itemType . '">';
    echo '    <button type="submit" class="btn btn-primary">Guardar Cambios</button>';
    echo '  </form>';
    echo '</div>';

    // Agrega este script para imprimir datos en la consola del navegador
    echo '<script>';
    echo '  console.log("Datos del ítem:", ' . json_encode($itemData) . ');';
    echo '</script>';

} else {
    echo '<p>Error: No se han proporcionado los parámetros necesarios.</p>';
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Item</title>
    <!-- Agrega tus enlaces a las hojas de estilo CSS y Bootstrap aquí -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <style>
        body {
            font-family: 'Arial', sans-serif;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
        }

        h2 {
            color: #007bff;
        }

        form {
            margin-top: 20px;
        }
    </style>
</head>
<body>

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<script>
$(document).ready(function() {
    // Manejar la presentación del formulario
    $('#editCoffeeForm, #editAdditionalDessertForm').submit(function(e) {
        e.preventDefault();
        // Realizar solicitud AJAX para actualizar el item en la base de datos
        $.ajax({
            url: 'updateItem.php',
            type: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                console.log('Respuesta del servidor:', response); // Agrega esta línea para ver la respuesta del servidor
                window.location.href = '../cart.html';
            },
            error: function(error) {
                console.error('Error en la solicitud AJAX:', error);
            }
        });
    });
});
</script>

</body>
</html>
