<?php

include '../componentes/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:admin_login.php');
}

if(isset($_GET['delete-coffe'])){
   $delete_idCoffe = $_GET['delete-coffe'];
   $delete_coffe = $conn->prepare("DELETE FROM `products_coffee` WHERE id = ?");
   $delete_coffe->execute([$delete_idCoffe]);
   header('location:productos_admin.php');
}

if(isset($_GET['delete-dessert'])){
   $delete_idDessert = $_GET['delete-dessert'];
   $delete_dessert = $conn->prepare("DELETE FROM `products_dessert` WHERE id = ?");
   $delete_dessert->execute([$delete_idDessert]);
   header('location:productos_admin.php');
}

if(isset($_GET['delete-additional'])){
   $delete_idAdditional = $_GET['delete-additional'];
   $delete_additional = $conn->prepare("DELETE FROM `products_additional` WHERE id = ?");
   $delete_additional->execute([$delete_idAdditional]);
   header('location:productos_admin.php');
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/adminStyle.css">
    <link rel="stylesheet" href="../css/admin_style.css">
    <title>Lista de productos</title>
    <style>
        .product-card {
            border: 1px solid #ccc;
            padding: 10px;
            margin: 10px;
            width: 300px;
            text-align: center;
        }

        .product-image {
            max-width: 100%;
            max-height: 200px;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
<?php include '../componentes/admin_header.php'; ?>
<section class="accounts">

   <h1 class="heading">Productos <br>Cafés</h1>

   <div class="box-container">

   <div class="box">
      <p>Agregar nuevo producto</p>
      <a href="../php/admin.php" class="option-btn">Registrar productos</a>
   </div>

   <?php
      $select_coffes = $conn->prepare("SELECT * FROM `products_coffee`");
      $select_coffes->execute();
      if($select_coffes->rowCount() > 0){
         while($fetch_coffes = $select_coffes->fetch(PDO::FETCH_ASSOC)){   
   ?>
   <div class="box">
      <img src="<?= $fetch_coffes['image_01']; ?>" alt="products" class="producto">
      <p> IDCafe: <span><?= $fetch_coffes['id']; ?></span> </p>
      <p> Nombre: <span><?= $fetch_coffes['name']; ?></span> </p>
      <p> Precio: $<span><?= $fetch_coffes['price']; ?></span> </p>
      <div class="flex-btn">
         <a href="productos_admin.php?delete-coffe=<?= $fetch_coffes['id']; ?>" onclick="return confirm('¿Eliminar este producto?')" class="delete-btn">Eliminar</a>
         <a href="update_producto.php?id=<?= $fetch_coffes['id'];?>&tipo=products_coffee" class="option-btn">Actualizar</a>
      </div>
   </div>
   <?php
         }
      }else{
         echo '<p class="empty">No hay Productos registrados</p>';
      }
   ?>

   </div>

</section>

<section class="accounts">

   <h1 class="heading">Postres</h1>

   <div class="box-container">

   <?php
      $select_dessert = $conn->prepare("SELECT * FROM `products_dessert`");
      $select_dessert->execute();
      if($select_dessert->rowCount() > 0){
         while($fetch_dessert = $select_dessert->fetch(PDO::FETCH_ASSOC)){   
   ?>
   <div class="box">
      <img src="<?= $fetch_dessert['image_01']; ?>" alt="products" class="producto">
      <p> IDPostre: <span><?= $fetch_dessert['id']; ?></span> </p>
      <p> Nombre: <span><?= $fetch_dessert['name']; ?></span> </p>
      <p> Precio: $<span><?= $fetch_dessert['price']; ?></span> </p>
      <div class="flex-btn">
         <a href="productos_admin.php?delete-dessert=<?= $fetch_dessert['id']; ?>" onclick="return confirm('¿Eliminar este producto?')" class="delete-btn">Eliminar</a>
         <a href="update_producto.php?id=<?= $fetch_dessert['id'];?>&tipo=products_dessert" class="option-btn">Actualizar</a>
      </div>
   </div>
   <?php
         }
      }else{
         echo '<p class="empty">No hay Productos registrados</p>';
      }
   ?>

   </div>

</section>

<section class="accounts">

   <h1 class="heading">Adicionales</h1>

   <div class="box-container">

   <?php
      $select_additional = $conn->prepare("SELECT * FROM `products_additional`");
      $select_additional->execute();
      if($select_additional->rowCount() > 0){
         while($fetch_additional = $select_additional->fetch(PDO::FETCH_ASSOC)){   
   ?>
   <div class="box">
      <img src="<?= $fetch_additional['image_01']; ?>" alt="products" class="producto">
      <p> IDAdicional: <span><?= $fetch_additional['id']; ?></span> </p>
      <p> Nombre: <span><?= $fetch_additional['name']; ?></span> </p>
      <p> Precio: $<span><?= $fetch_additional['price']; ?></span> </p>
      <div class="flex-btn">
         <a href="productos_admin.php?delete-additional=<?= $fetch_additional['id']; ?>" onclick="return confirm('¿Eliminar este producto?')" class="delete-btn">Eliminar</a>
         <a href="update_producto.php?id=<?= $fetch_additional['id'];?>&tipo=products_additional" class="option-btn">Actualizar</a>
      </div>
   </div>
   <?php
         }
      }else{
         echo '<p class="empty">No hay Productos registrados</p>';
      }
   ?>

   </div>

</section>

<script src="../js/admin_script.js"></script>
   
</body>
</html>
