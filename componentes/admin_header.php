<?php
   if(isset($message)){
      foreach($message as $message){
         echo '
         <div class="message">
            <span>'.$message.'</span>
            <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
         </div>
         ';
      }
   }
?>

<header class="header">

   <section class="flex">

      <a href="../admin/dashboard.php" class="logo">Panel<span>Admin</span></a>

      <nav class="navbar">
         <a href="../admin/dashboard.php">Inicio</a>
         <a href="../admin/productos_admin.php">Productos</a>
         <a href="../admin/placed_orders.php">Reportes</a>
         <a href="../admin/admin_accounts.php">Administradores</a>
         <a href="../admin/users_accounts.php">Usuarios</a>
      </nav>

      <div class="icons">
         <div id="menu-btn" class="fas fa-bars"></div>
         <div id="user-btn" class="fas fa-user"></div>
      </div>

      <div class="profile">
         <?php
            $select_profile = $conn->prepare("SELECT * FROM `admins` WHERE id = ?");
            $select_profile->execute([$admin_id]);
            $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
         ?>
         <p><?= $fetch_profile['name']; ?></p>
         <a href="../admin/update_profile.php" class="btn">Actualizar perfil</a>
         <div class="flex-btn">
            <a href="../admin/register_admin.php" class="option-btn">Registrar</a>
            <a href="../admin/admin_login.php" class="option-btn">Iniciar sesion</a>
         </div>
         <a href="../componentes/admin_logout.php" class="delete-btn" onclick="return confirm('logout from the website?');">Cerar sesion</a> 
      </div>
   </section>

</header>