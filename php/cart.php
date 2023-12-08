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

// Verificar si 'product' está presente en $_POST
if (isset($_POST['product'])) {
    // Obtener datos del producto desde la solicitud POST
    $productData = json_decode($_POST['product'], true);

    // Verifica si se están decodificando correctamente los datos
    if ($productData === null && json_last_error() !== JSON_ERROR_NONE) {
        echo "Error al decodificar los datos JSON.";
        exit();
    }

    if (isset($productData['name'])) {
        // Datos del menú (menu.js)
        $name = $productData['name'];
        $price = $productData['price'];
        $image_01 = $productData['image_01'];

        // Verificar si el producto ya existe en el carrito
        $existingProductQuery = "SELECT * FROM cart_additional_dessert WHERE name = '$name'";
        $result = $conn->query($existingProductQuery);

        if ($result->num_rows > 0) {
            // El producto ya existe, actualiza la cantidad y el precio
            $row = $result->fetch_assoc();
            $quantity = $row['quantity'] + 1;
            $newPrice = $price * $quantity;

            $updateQuery = "UPDATE cart_additional_dessert SET quantity = $quantity, price = $newPrice WHERE name = '$name'";
            if ($conn->query($updateQuery) === TRUE) {
                echo "Cantidad y precio actualizados correctamente";
            } else {
                echo "Error al actualizar la cantidad y el precio: " . $conn->error;
            }
        } else {
            // El producto no existe, inserta una nueva fila
            $quantity = 1;
            $newPrice = $price * $quantity;

            $insertQuery = "INSERT INTO cart_additional_dessert (name, price, image_01, quantity, baseprice) VALUES ('$name', $newPrice, '$image_01', $quantity, $price)";
            if ($conn->query($insertQuery) === TRUE) {
                echo "Producto agregado al carrito";
            } else {
                echo "Error al agregar el producto al carrito: " . $conn->error;
            }
        }
    } elseif (isset($productData['cname'])) {
        // Datos de detallesProducto (detallesProducto.js)
        $cname = $productData['cname'];
        $cprice = $productData['cprice'];
        $cimage_01 = $productData['cimage_01'];
        $cmilktype = $productData['cmilkType'];
        $csize = $productData['csize'];
        $cquantity = $productData['cquantity'];
        $cnewPrice = $cprice * $cquantity;
        $cbaseprice = $productData['cbaseprice'];

        // Insertar datos en la tabla cart_coffee
        $sql = "INSERT INTO cart_coffee (name, price, image_01, milktype, size, quantity, baseprice) VALUES ('$cname', $cnewPrice, '$cimage_01', '$cmilktype', '$csize', $cquantity, $cbaseprice)";
        
        // Ejecutar la consulta SQL
        if ($conn->query($sql) === TRUE) {
            echo "Datos agregados correctamente";
        } else {
            echo "Error al agregar datos: " . $conn->error;
        }
    } else {
        // No se reconoce el formato de datos
        echo "Error: Formato de datos no reconocido";
        exit();
    }
} else {
    // La clave 'product' no está presente en $_POST
    echo "Error: Datos del producto no proporcionados.";
}

// Cerrar la conexión
$conn->close();
?>