<?php

  if(!isset($_SESSION)) {
    session_start();
  }

//  include_once("../includes/controller.php");
//  require_once("../autoloader.php");
/*
  include_once("../classes/Database/Database.php");
  include_once("../classes/Models/User.php");*/



  if(isset($_SESSION['user_id']) && $_SESSION['role'] === "Administrator") {
    $title = "Employees";


    include_once("../includes/partials/header.php");
    include_once("../includes/partials/navigation.php");

    $positionsController = new \Controllers\PositionController();

    $userController = new \Controllers\UserController($loggedUserId);
//    var_dump($userController);
    $filterValue = "all";
//    echo "test";
    if(isset($_SESSION['filterVal'])) {
      $filterValue = $_SESSION['filterVal'];
      if($filterValue !== "all") {
        $filterValue = $positionsController->getPositionNameById($filterValue);
      }
    }


    $updateResult = "";
    if(isset($_SESSION['update_result'])) {
      $updateResult = $_SESSION['update_result'];
      unset($_SESSION['update_result']);
    }


//  echo $require_test;
    $positionsArr = $positionsController->getAllPositions();
    $usersArr = $userController->getUsersByFilteredData($filterValue);

    ?>
    <div class="container flex flex-center flex-column ">

      <div class="employees-header flex justify-cont-between">
        <form class="form-filter flex" action="../includes/controller.php" method="POST">
          <select name="positions">
            <option value="all">All</option>
            <?php foreach($positionsArr as $position): ?>
              <option value="<?= $position['position_id'] ?>"><?= $position['position_name']; ?></option>
            <?php endforeach; ?>
          </select>
          <button class="btn btn-submit" type="submit" name="positionFilter">Refresh</button>
          <?= !empty($updateResult) ? "<br><span class='text-info'>Last change: $updateResult</span>" : ""; ?>
        </form>
        <form action="./createEmployee.php">
          <button type="submit" class="btn btn-edit add-employee">Add New Employee</button>
        </form>
      </div>



      <table class="table">
        <thead>
          <tr>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Position</th>
            <th>Email</th>
            <th>Salary</th>
            <th>Options</th>
          </tr>
        </thead>
        <tbody>

          <?php foreach($usersArr as $user): ?>
            <tr>
              <td><?= $user['firstname']; ?></td>
              <td><?= $user['lastname']; ?></td>
              <td><?= $user['position_name']; ?></td>
              <td><?= $user['email']; ?></td>
              <td><?= $user['salary']; ?>$</td>
              <td class="flex flex-row justify-cont-between">
                <form action="./editEmployee.php" method="POST">
                  <input type="hidden" name="targetEmployeeId" value="<?= $user['employee_id']; ?>">
                  <div class="form-group ">
                    <button type="submit" class="btn btn-edit" name="editEmployee">Edit</button>
                  </div>

                </form>
                <form action="../includes/controller.php" method="POST">
                  <input type="hidden" name="targetEmployeeId" value="<?= $user['employee_id']; ?>">
                  <div class="form-group flex flex-row">
                    <?php if($user['position_name'] !== "Administrator"): ?>
                      <button type="submit" class="btn btn-delete" name="deleteEmployee">Delete</button>
                    <?php endif; ?>
                  </div>
                </form>

              </td>

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



