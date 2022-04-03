<?php

  session_start();
//  require_once("../autoloader.php");

  if(isset($_SESSION['user_id']) && $_SESSION['role'] === "Administrator") {
    $title = "Dashboard";
    include_once("../includes/partials/header.php");
    include_once("../includes/partials/navigation.php");



    $dashboardController = new \Controllers\DashboardController();
    $numberOfEmployees = $dashboardController->getTotalNumberOfEmployees();
    $averageSalary = $dashboardController->getAvgSalary();
    $numberOfEmployeesPerRole = $dashboardController->getGroupedEmployees();


    ?>
    <div class="container flex flex-center flex-column ">

      <?= "Total Number of employees: ". $numberOfEmployees; ?>
      <br>
      <?= "Average Salary: $averageSalary"; ?>
      <hr>
      <table class="employees-table">
        <thead>
          <tr>
            <th>Role</th>
            <th>Number of Employees</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach($numberOfEmployeesPerRole as $distinctData): ?>
            <tr>
              <td><?= $distinctData['position_name']; ?></td>
              <td><?= $distinctData['distinct_position']; ?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>




    </div>
    <?php

    include_once("../includes/partials/footer.php");
  } else {
    header("Location: ../index.php");
  }


