<?php

  session_start();
//  require_once("../autoloader.php");

  if(isset($_SESSION['user_id']) && $_SESSION['role'] === "Administrator") {
    $title = "Dashboard";
    include_once("../includes/partials/header.php");
    include_once("../includes/partials/navigation.php");

    ?>
    <div class="container flex flex-center flex-column ">




    </div>
    <?php

    include_once("../includes/partials/footer.php");
  } else {
    header("Location: ../index.php");
  }


