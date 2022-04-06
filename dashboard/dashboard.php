<?php

  if(!isset($_SESSION)) {
    session_start();
  }

  if(isset($_SESSION['user_id']) && $_SESSION['role'] === "Administrator") {
    $title = "Dashboard";
    include_once("../includes/partials/header.php");
    include_once("../includes/partials/navigation.php");
    $dashboardController = new \Controllers\DashboardController();
    $numberOfEmployees = $dashboardController->getTotalNumberOfEmployees();
    $dashboardController->setAverageSalary();
    $dashboardController->setGroupedEmployeeData();
    $dashboardController->setNumberOfEmployees();
    $averageSalary = $dashboardController->getAvgSalary();
    $numberOfEmployeesPerRole = $dashboardController->getGroupedEmployees();



    ?>
    <div class="container flex flex-column ">

      <div class="dashboard-info flex flex-column">

        <div class="info-group">
          <?= "Total Number of employees: ". $numberOfEmployees; ?>
        </div>
        <div class="info-group">
          <?= "Average Salary: $averageSalary$"; ?>
        </div>
      </div>


      <table class="table dashboard-table">
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


