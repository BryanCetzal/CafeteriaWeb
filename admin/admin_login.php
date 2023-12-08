<?php

include '../componentes/connect.php';

session_start();

if(isset($_POST['submit'])){

   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);
   $pass = sha1($_POST['pass']);
   $pass = filter_var($pass, FILTER_SANITIZE_STRING);

   $select_admin = $conn->prepare("SELECT * FROM `admins` WHERE name = ? AND password = ?");
   $select_admin->execute([$name, $pass]);
   $row = $select_admin->fetch(PDO::FETCH_ASSOC);

   if($select_admin->rowCount() > 0){
      $_SESSION['admin_id'] = $row['id'];
      header('location:dashboard.php');
   }else{
      $message[] = 'incorrect username or password!';
   }

}

?>

<!DOCTYPE html>
<html lang="es">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>login</title>

   <link rel="stylesheet" href="../css/usuario.css">

</head>
<body>

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

<div class="container">
   <div class="left-side">
      <div class="container-logo">
         <img src="../img/Logo.png" alt="Logo de la empresa" class="logo">
      </div>
   </div>
   <div class="right-side">
      <form action="" method="post">
         <h1>Administradores </h1>
         <h2>Bryben</h2>
         <input type="text" name="name" required placeholder="Usuario" maxlength="20"  class="box" oninput="this.value = this.value.replace(/\s/g, '')">
         <input type="password" name="pass" required placeholder="Contraseña" maxlength="20"  class="box" oninput="this.value = this.value.replace(/\s/g, '')">
         <input type="submit" value="Iniciar sesion" class="btn" name="submit">
      </form>
   </div>
</div>
   
</body>
</html>