<?php
// Recuperar datos del formulario
$itemId = $_POST['itemId'];
$itemType = $_POST['itemType'];
$newQuantity = $_POST['quantity'];

// Crear conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "cafeteria_db";

$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Actualizar los datos en la base de datos
if ($itemType === 'coffee') {
    $newMilkType = $_POST['milktype'];
    $newSize = $_POST['size'];

    $updateQuery = "UPDATE cart_coffee SET milktype = ?, size = ?, quantity = ? WHERE id = ?";
} else {
    $updateQuery = "UPDATE cart_additional_dessert SET quantity = ? WHERE id = ?";
}

// Utilizar consultas preparadas para evitar inyección de SQL
$stmtUpdate = $conn->prepare($updateQuery);

if ($itemType === 'coffee') {
    $stmtUpdate->bind_param("ssii", $newMilkType, $newSize, $newQuantity, $itemId);
} else {
    $stmtUpdate->bind_param("ii", $newQuantity, $itemId);
}

if ($stmtUpdate->execute()) {
    // Obtener información actualizada del ítem
    $itemDataQuery = "SELECT * FROM cart_$itemType WHERE id = $itemId";
    $itemDataResult = $conn->query($itemDataQuery);

    if ($itemDataResult->num_rows > 0) {
        $itemData = $itemDataResult->fetch_assoc();

        // Calcular el precio según el tipo de ítem y tamaño
        $price = 0;

        if ($itemType === 'coffee') {
            // Ajustar precio según tamaño
            if ($itemData['size'] === 'Chico') {
                $price = ($itemData['baseprice'] - 5) * $newQuantity;
            } elseif ($itemData['size'] === 'Grande') {
                $price = ($itemData['baseprice'] + 5) * $newQuantity;
            } else {
                // Si no es 'Chico' ni 'Grande', usar el precio original
                $price = $itemData['baseprice'] * $newQuantity;
            }
        } else {
            // Para adicionales o postres, simplemente multiplicar por la cantidad
            $price = $itemData['baseprice'] * $newQuantity;
        }

        // Actualizar el precio en la base de datos
        $updatePriceQuery = "UPDATE cart_$itemType SET price = ? WHERE id = ?";
        $stmtUpdatePrice = $conn->prepare($updatePriceQuery);
        $stmtUpdatePrice->bind_param("ii", $price, $itemId);

        if ($stmtUpdatePrice->execute()) {
            // Redirigir de vuelta a la página del carrito después de la actualización
            header('Location: cart.php');
            exit();
        } else {
            echo "Error al actualizar el precio: " . $stmtUpdatePrice->error;
        }
    } else {
        echo "No se encontraron datos para el ítem con ID $itemId";
    }
} else {
    echo "Error al actualizar los datos: " . $stmtUpdate->error;
}

// Cerrar la conexión
$stmtUpdate->close();
$conn->close();
?>
