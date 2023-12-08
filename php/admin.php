<?php
if (isset($_POST['submit'])) {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "cafeteria_db";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    // Obtener la sección directamente del formulario POST
    $section = $_POST['section'];

    $name = $_POST['name'];
    $details = $_POST['details'];
    $price = $_POST['price'];

    $targetDir = "../uploads/";
    $targetFile = $targetDir . basename($_FILES["image"]["name"]);
    move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile);

    // Agregar a la tabla correspondiente según la sección seleccionada
    $sql = "INSERT INTO $section (name, details, price, image_01) VALUES ('$name', '$details', '$price', '$targetFile')";

    if ($conn->query($sql) === TRUE) {
        $lastInsertedId = $conn->insert_id;
        echo "Producto agregado correctamente.";
    } else {
        echo "Error al agregar el producto: " . $conn->error;
    }

    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administrador</title>
    <link rel="stylesheet" href="../css/adminStyle.css">
</head>
<body>
    <div class="container">
        <h2>Panel de Administrador</h2>
        <!-- Formulario con el campo de selección de sección -->
        <form action="admin.php" method="POST" enctype="multipart/form-data">
            <!-- Campo de selección de sección -->
            <label for="section">Sección:</label>
            <select name="section" id="section">
                <option value="Products_Coffee">Cafés</option>
                <option value="Products_Dessert">Postres</option>
                <option value="Products_Additional">Adicionales</option>
            </select>
            
            <label for="name">Nombre del Producto:</label>
            <div class="input-with-counter">
                <input type="text" id="name" name="name" required maxlength="25" oninput="updateCharCount('name', 'nameCount')">
                <span id="nameCount">0/25</span>
            </div>

            <label for="details">Detalles del Producto:</label>
            <div class="input-with-counter">
                <input type="text" id="details" name="details" required maxlength="75" oninput="updateCharCount('details', 'detailsCount')"></input>
                <span id="detailsCount">0/75</span>
            </div>

            <label for="price">Precio:</label>
            <input type="number" id="price" name="price" required>

            <label for="image">Imagen:</label>
            <input type="file" id="image" name="image" accept="image/*" required>

            <button type="submit" name="submit">Agregar Producto</button>
        </form>
    </div>
    <script>
        function updateCharCount(inputId, countId) {
            var input = document.getElementById(inputId);
            var countSpan = document.getElementById(countId);
            var currentCount = input.value.length;
            var maxLength = input.maxLength;
            countSpan.textContent = currentCount + '/' + maxLength;
        }
    </script>
</body>
</html>
