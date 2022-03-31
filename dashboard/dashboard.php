<?php

  session_start();
  require_once("../autoloader.php");

  if(isset($_SESSION['user_id']) && $_SESSION['role'] === "Administrator") {
    $title = "Naslovna";
    include_once("../includes/partials/header.php");
    include_once("../includes/partials/navigation.php");

    echo $_SESSION['user_id'];
    echo __DIR__;


    include_once("../includes/partials/footer.php");
  } else {
    header("Location: ../index.php");
  }


