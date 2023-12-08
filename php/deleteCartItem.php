<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "cafeteria_db";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Obtener ID y tipo del elemento a eliminar
$itemId = $_POST['id'];
$itemType = $_POST['type'];

// Eliminar el elemento de la base de datos según su tipo
if ($itemType === 'additional_dessert') {
    $sql = "DELETE FROM cart_additional_dessert WHERE id = $itemId";
} elseif ($itemType === 'coffee') {
    $sql = "DELETE FROM cart_coffee WHERE id = $itemId";
} else {
    echo "Tipo de elemento no válido";
    exit();
}

// Ejecutar la consulta SQL
if ($conn->query($sql) === TRUE) {
    echo "Elemento eliminado correctamente";
} else {
    echo "Error al eliminar elemento: " . $conn->error;
}

// Cerrar la conexión
$conn->close();
?>