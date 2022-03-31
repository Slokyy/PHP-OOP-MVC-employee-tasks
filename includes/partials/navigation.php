<?php
//  require_once("../classes/Database/Database.php");
//  require_once("../classes/Models/User.php");
?>
<nav class="navbar">
  <div class="container flex">
    <div class="nav-group">
      <a href="./dashboard.php">Naslovna</a>
      <a href="./employees.php">Zaposleni</a>
    </div>
    <div class="nav-group">
      <?php if(isset($_SESSION["user_id"])): ?>
        <?php
          $user = new \Models\User();
          echo $user->getLoggedUserEmail($_SESSION['user_id']);
        ?>
        <a href="../index.php">Log out</a>
      <?php endif; ?>
      <?php if(!isset($_SESSION["user_id"])): ?>
        <a href="../index.php">Log in</a>
      <?php endif; ?>
    </div>
  </div>
</nav>