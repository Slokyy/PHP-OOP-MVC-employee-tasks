<?php


  include_once("../autoloader.php");

/*  include_once("../classes/Database/Database.php");
  include_once("../classes/Models/User.php");
  include_once("../classes/Controllers/UserController.php");
  include_once("../classes/Controllers/LoginController.php");*/
  use Models\User;
  use Controllers\LoginController;
  use Controllers\UserController;


//  var_dump($_POST['login'], $_POST['email'], $_POST['password']);

  if(isset($_POST['login']) && !empty($_POST['email']) && !empty($_POST['password'])) {

    $email = $_POST['email'];
    $password = $_POST['password'];
    $userLogData = new LoginController();
    $result = $userLogData->getLoggedUser($email, $password);
    echo "Uspeh:";
    var_dump($result);
  } else {
    header("Location: ../index.php");
  }
