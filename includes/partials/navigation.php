<?php
  require_once("../autoloader.php");

  use Database\Database;
  use Controllers\UserController;
  $loggedUserId = $_SESSION['user_id'];
  $loggedUser = new UserController($loggedUserId);
  $userDataArr = $loggedUser->getUserDataArr();

  $employeeName = $loggedUser->getUserName();
  $employeeLastName = $loggedUser->getUserLastName();
  $employeeEmail = $loggedUser->getUserEmail();
  $employeeRole = $loggedUser->getUserRole();
//  var_dump($userDataArr)

?>
<nav class="navbar">
  <div class="nav-container flex justify-cont-between">
    <div class="nav-group">
      <a href="./dashboard.php">Dashboard</a>
      <a href="./employees.php">Employees</a>
    </div>
    <div class="nav-group">
      <?php if(isset($_SESSION["user_id"])): ?>
        <span class="navlog-info">
          <?= "$employeeName $employeeLastName ( $employeeRole)" ?>
        </span>
        <a href="../index.php">Log out</a>
      <?php endif; ?>

      <?php
//      var_dump($userDataArr);
      ?>
    </div>
  </div>
</nav>