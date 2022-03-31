<?php
//  require_once("../classes/Database/Database.php");
//  require_once("../classes/Models/User.php");
//  require_once("../classes/Controllers/UserController.php");
//  include_once("../includes/controller.php");
//  use \Controllers\UserController;
  session_start();
//  var_dump($_SESSION['user_id'], $_SESSION['role']);
  if(isset($_SESSION['user_id']) && $_SESSION['role'] === "Administrator") {
    $title = "Naslovna";
//    $userContr = new UserController();
//    $userEmail = $userContr->getUserEmail($_SESSION['user_id']);
//    $userEmail = test();
    include_once("../includes/partials/header.php");
    include_once("../includes/partials/navigation.php");

    echo $_SESSION['user_id'];


    include_once("../includes/partials/footer.php");
  } else {
    header("Location: ../index.php");
  }


