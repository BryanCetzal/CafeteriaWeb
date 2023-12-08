<?php
// Conectar a la base de datos (reemplaza estas variables según tu configuración)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "cafeteria_db";

$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Obtener la sección directamente del formulario POST
$section = isset($_POST['section']) ? $_POST['section'] : '';
//echo "Sección: $section";

if (!empty($section)) {
    // Obtener la lista de productos para la sección específica
    $sql = "SELECT * FROM $section";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $products = [];

        while ($row = $result->fetch_assoc()) {
            $products[] = $row;
        }

        // Devolver los productos como JSON
        header('Content-Type: application/json');
        echo json_encode($products);
    } else {
        echo json_encode([]);
    }
} else {
    echo json_encode([]);
}

$conn->close();
?>