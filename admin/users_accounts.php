<?php

include '../componentes/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:admin_login.php');
}

if(isset($_GET['delete'])){
   $delete_id = $_GET['delete'];
   $delete_user = $conn->prepare("DELETE FROM `users` WHERE id = ?");
   $delete_user->execute([$delete_id]);
   header('location:users_accounts.php');
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Cuentas de usuario</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <link rel="stylesheet" href="../css/admin_style.css">

</head>
<body>

<?php include '../componentes/admin_header.php'; ?>

<section class="accounts">

   <h1 class="heading">Cuentas de usuario</h1>

   <div class="box-container">

   <?php
      $select_accounts = $conn->prepare("SELECT * FROM `users`");
      $select_accounts->execute();
      if($select_accounts->rowCount() > 0){
         while($fetch_accounts = $select_accounts->fetch(PDO::FETCH_ASSOC)){   
   ?>
   <div class="box">
      <p> ID Usuario: <span><?= $fetch_accounts['id']; ?></span> </p>
      <p> Nombre : <span><?= $fetch_accounts['user']; ?></span> </p>
      <p> Email : <span><?= $fetch_accounts['email']; ?></span> </p>
      <a href="users_accounts.php?delete=<?= $fetch_accounts['id']; ?>" onclick="return confirm('¿Eliminar esta cuenta? La informacion relacionada al usuario se perdera')" class="delete-btn">Eliminar</a>
   </div>
   <?php
         }
      }else{
         echo '<p class="empty">No hay usuarios</p>';
      }
   ?>

   </div>

</section>












<script src="../js/admin_script.js"></script>
   
</body>
</html>