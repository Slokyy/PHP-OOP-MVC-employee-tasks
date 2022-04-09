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
      <a href="./dashboard.php" class="nav-link">Dashboard</a>
      <a href="./employees.php" class="nav-link">Employees</a>
      <div class="dropdown">
        <a href="javascript:void(0)" class="dropbtn nav-link">Projects 🔻</a>
        <span class="dropdown-content">
          <a href="./all-tasks.php">💰 All Tasks</a>
          <a href="./create-project">📚 Create Project</a>
          <a href="./create-task">📝 Create Task</a>
        </span>


      </div>
    </div>
    <div class="nav-group">
      <?php if(isset($_SESSION["user_id"])): ?>
        <span class="navlog-info">
          <?= "$employeeName $employeeLastName ( $employeeRole)" ?>
        </span>
        <a href="../index.php" class="nav-link">Log out</a>
      <?php endif; ?>

      <?php
//      var_dump($userDataArr);
      ?>
    </div>
  </div>
</nav>