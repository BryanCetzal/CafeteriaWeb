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
    <div class="menu menu_contenedor">
        <div class="logo_contenedor">
            <a href="index.php" class="logoblanco"><img src="img/Logo.png" alt=""></a>
            <a href="index.php" class="logodorado"><img src="img/LogoDorado.png" alt=""></a>
        </div>
        
        <input type="checkbox" id="menu" />
        <label for="menu">
            <img src="img/menu.png" class="menu-icono" alt="menu">
        </label>
            
        <nav class="navbar">
            <ul>
                <li class="seleccionado"><a href="index.php">Inicio</a></li>
                <li class="no_seleccionado"><a href="menu.html">Menú</a></li>
                <li class="no_seleccionado"><a href="#">Reservaciones</a></li>
                <li class="no_seleccionado"><a href="#">Sucursales</a></li>
            </ul>
        </nav>

        
        <div class="icons">
            <div id="menu-btn" class="fas fa-bars"></div>
               <a href="cart.php"><i class="fas fa-shopping-cart"></i><span></span></a>
            <div id="user-btn" class="fas fa-user"></div>
        </div>

        <div class="profile">
        <?php          
            $select_profile = $conn->prepare("SELECT * FROM `users` WHERE id = ?");
            $select_profile->execute([$user_id]);
            if($select_profile->rowCount() > 0){
            $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
         ?>
         <p><?= $fetch_profile["user"]; ?></p>
         <a href="update_usuario.php" class="btn">Actualizar datos</a>
         <div class="flex-btn">
            <a href="registro_usuario.php" class="option-btn">Registrar</a>
            <a href="login.php" class="option-btn">Iniciar sesion</a>
         </div>
         <a href="componentes/user_logout.php" class="delete-btn" onclick="return confirm('¿Estas seguro de cerrar la sesion?');">Cerrar sesion</a> 
         <?php
            }else{
         ?>
         <p>Inicia sesion o registrate</p>
         <div class="flex-btn">
            <a href="registro_usuario.php" class="option-btn">Registrarme</a>
            <a href="login.php" class="option-btn">Iniciar sesion</a>
         </div>
         <?php
            }
         ?>      
        </div>
         
        
    </div>
    <div class="header_contenido contenedor">
            <div class="header_txt">
                <h1>Cafetería Bryben</h1>
                <p>Donde el café es arte y la vida es un sorbo</p>
            </div>
        </div>
    </header>