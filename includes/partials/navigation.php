<?php
  require_once("../autoloader.php");

  use Database\Database;
  use Controllers\UserController;
  $userData = new UserController();
  $userDataArr = $userData->getLoggedUserInfo($_SESSION['user_id']);
  $employeeName = $userDataArr['firstname'];
  $employeeLastName = $userDataArr['lastname'];
  $employeeEmail = $userDataArr['email'];
  $employeeRole = $userDataArr['position_name'];

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