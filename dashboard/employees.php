<?php

  session_start();

//  include_once("../includes/controller.php");
  require_once("../autoloader.php");
/*
  include_once("../classes/Database/Database.php");
  include_once("../classes/Models/User.php");*/
  use Database\Database;
  use Models\User;

  $title = "Zaposleni";


  include_once("../includes/partials/header.php");
  $user = new User();

  include_once("../includes/partials/navigation.php");

//  echo $require_test;
  ?>
  <div class="container">
    <?php
      var_dump($user->getAllUsers());

    ?>
  </div>
  <?php
//  require_once("../includes/controller.php");



  include_once("../includes/partials/footer.php");

