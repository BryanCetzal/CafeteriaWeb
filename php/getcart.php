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

// Consultar datos de cart_additional_dessert
$sql_additional_dessert = "SELECT * FROM cart_additional_dessert";
$result_additional_dessert = $conn->query($sql_additional_dessert);
$cart_additional_dessert = [];

if ($result_additional_dessert->num_rows > 0) {
    while ($row = $result_additional_dessert->fetch_assoc()) {
        $cart_additional_dessert[] = $row;
    }
}

// Consultar datos de cart_coffee
$sql_coffee = "SELECT * FROM cart_coffee";
$result_coffee = $conn->query($sql_coffee);
$cart_coffee = [];

if ($result_coffee->num_rows > 0) {
    while ($row = $result_coffee->fetch_assoc()) {
        $cart_coffee[] = $row;
    }
}

// Combinar resultados en un solo array
$cart_data = [
    'additional_dessert' => $cart_additional_dessert,
    'coffee' => $cart_coffee
];

// Devolver los datos en formato JSON
header('Content-Type: application/json');
echo json_encode($cart_data);

// Cerrar la conexión
$conn->close();
?>
