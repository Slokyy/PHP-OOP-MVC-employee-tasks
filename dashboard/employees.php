<?php

  session_start();

//  include_once("../includes/controller.php");
//  require_once("../autoloader.php");
/*
  include_once("../classes/Database/Database.php");
  include_once("../classes/Models/User.php");*/


  if(isset($_SESSION['user_id']) && $_SESSION['role'] === "Administrator") {
    $title = "Zaposleni";


    include_once("../includes/partials/header.php");
    include_once("../includes/partials/navigation.php");

//  echo $require_test;
    ?>
    <div class="container">
      <?php
        var_dump($userData->getAllUsers());
      ?>
    </div>
    <?php
//  require_once("../includes/controller.php");



    include_once("../includes/partials/footer.php");
  } else {
    header("Location: ../index.php");
  }



