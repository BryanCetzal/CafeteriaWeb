<?php

include '../componentes/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:admin_login.php');
}

// Definir variables para almacenar los valores recuperados
$id_producto = null;
$tipo_producto = null;
$nombre_producto = null;
$precio_producto = null;

// En editar_producto.php
if (isset($_GET['id']) && isset($_GET['tipo'])) {
    $id_producto = $_GET['id'];
    $tipo_producto = $_GET['tipo'];

    try {
        // Establecer el modo de error PDO para excepciones
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Consultar la base de datos para obtener la información del producto
        $query = "SELECT * FROM $tipo_producto WHERE id = :id";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':id', $id_producto);
        $stmt->execute();

        // Obtener los datos del producto
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if ($stmt->rowCount() > 0) {
            // Almacenar los valores recuperados en variables
            foreach ($result as $row) {
                $nombre_producto = $row['name'];
                $precio_producto = $row['price'];
                $detalles_producto = $row['details'];
                $imagen_producto = $row['image_01'];
            }
        } else {
            echo "No se encontró el producto en la base de datos.";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }

} else {
    // Manejar el caso en el que no se proporciona un ID de producto o un tipo de producto válido.
    echo "ID o tipo de producto no válido.";
}


// Procesar el formulario cuando se envía
if (isset($_POST['submit'])) {
   // Recuperar los valores del formulario
   $nueva_imagen = $_FILES['nueva_imagen']['name'];
   $nombre_producto = $_POST['name'];
   $detalles_producto = $_POST['details'];
   $precio_producto = $_POST['price'];

   // Actualizar la base de datos con los nuevos valores
   try {
       // Establecer el modo de error PDO para excepciones
       $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

       // Actualizar la imagen solo si se proporciona una nueva
       if (!empty($nueva_imagen)) {
         if (move_uploaded_file($_FILES['nueva_imagen']['tmp_name'], "../uploads/" . $nueva_imagen)) {
            echo "Imagen cargada exitosamente.";
        } else {
            echo "Error al cargar la imagen: " . $_FILES['nueva_imagen']['error'];
        }
           $imagen_producto = "../uploads/" . $nueva_imagen;
           // Actualizar la base de datos con la nueva ruta de la imagen
           $update_query = "UPDATE $tipo_producto SET image_01 = :image WHERE id = :id";
           $update_stmt = $conn->prepare($update_query);
           $update_stmt->bindParam(':image', $imagen_producto);
           $update_stmt->bindParam(':id', $id_producto);
           $update_stmt->execute();
       }
      

       // Actualizar otros campos en la base de datos, incluyendo la imagen
      $update_query = "UPDATE $tipo_producto SET name = :name, details = :details, price = :price, image_01 = :image WHERE id = :id";
      $update_stmt = $conn->prepare($update_query);
      $update_stmt->bindParam(':name', $nombre_producto);
      $update_stmt->bindParam(':details', $detalles_producto);
      $update_stmt->bindParam(':price', $precio_producto);
      $update_stmt->bindParam(':image', $imagen_producto);  // Ajustado a 'image_01'
      $update_stmt->bindParam(':id', $id_producto);
      $update_stmt->execute();


       echo "Producto actualizado exitosamente.";

   } catch (PDOException $e) {
       echo "Error al actualizar el producto: " . $e->getMessage();
   }
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Actualizar productos disponibles</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <link rel="stylesheet" href="../css/admin_style.css">

</head>
<body>

<?php include '../componentes/admin_header.php'; ?>

<section class="form-container">

   <form action="" method="post" enctype="multipart/form-data">
      <h3>Actualizar Producto</h3>
      
      <img src="<?php echo $imagen_producto; ?>" alt="Imagen del producto" width="100">
       
      <div class="box">
         <label for="nueva_imagen">Cargar nueva imagen:</label>
         <input type="file" id= "image" name="nueva_imagen" accept="image/*" >
      </div>
      
      <div class="box">
         <span id="nameCount">0/25</span>
         <input type="text" id="name" name="name" placeholder="Nombre del producto" value="<?php echo $nombre_producto; ?>" required maxlength="25" class="box"
         oninput="updateCharCount('name', 'nameCount')"></input>
      </div>
      
      <div class="box">
         <span id="detailsCount">0/75</span>
         <input type="text" id="details" name="details" value="<?php echo $detalles_producto; ?>" required maxlength="75" 
         oninput="updateCharCount('details', 'detailsCount')" class="box"></input>
      </div>
      
      <input type="number" id="price" name="price"  value="<?php echo $precio_producto; ?>" required class="box">

      <input type="submit" value="Actualizar producto" class="btn" name="submit">
   </form>

</section>
    <script>
        function updateCharCount(inputId, countId) {
            var input = document.getElementById(inputId);
            var countSpan = document.getElementById(countId);
            var currentCount = input.value.length;
            var maxLength = input.maxLength;
            countSpan.textContent = currentCount + '/' + maxLength;
        }
    </script>

<script src="../js/admin_script.js"></script>
   
</body>
</html>