<?php

  session_start();

//  include_once("../includes/controller.php");
  require_once("../classes/Database/Database.php");
  require_once("../classes/Models/User.php");
  use Database\Database;
  use Models\User;

  $title = "Zaposleni";


  include_once("../includes/partials/header.php");
  include_once("../includes/partials/navigation.php");

//  echo $require_test;
  $user = new User();
  ?>
  <div class="container">
    <?php
      var_dump($user->getAllUsers());

    ?>
  </div>
  <?php
//  require_once("../includes/controller.php");



  include_once("../includes/partials/footer.php");

