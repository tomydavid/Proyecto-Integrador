<?php
require '../validacion.php';

if (isset($_COOKIE['email'])) {
    $email= $_COOKIE['email'];
  }
if($_SESSION){

  header('Location:bienvenido.php');

} else {
  if ($_POST) {


    $errores = validarLogIn();
    if (!$errores) {
      $host= 'mysql:host=localhost;dbname=IKIGAI;charset=utf8mb4;port=3306';
      $db_user= 'root';
      $db_pass='root';
      $db = new PDO ($host, $db_user, $db_pass);
      $query = $db->prepare('SELECT email, password FROM usuarios where email = :email;');
      $email = $_POST['email'];
      $query->bindValue(':email', $email, PDO::PARAM_STR);
      $query->execute();
      $results = $query->fetch(PDO::FETCH_ASSOC);
      var_dump($results); 
      var_dump($_POST);
      echo '<br>verificando clave->'.password_verify($_POST['password'], $results['password']);
      if (password_verify($_POST['password'], $results['password'])) {
        echo 'Todo bien';
        almacenarEnSession($results);

        header('Location:Bienvenido.php');
      } else {
        $errores['email'] = "password o email incorrecto";

      }
      echo 'no hice nada';



    }
  }
}



?>
<html>
                <button type="button" >Olvide mi contraseña</button>
              </div>
              <div class="enviar">
                <div class="twitter">