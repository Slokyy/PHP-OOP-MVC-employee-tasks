<?php

  session_start();

//  include_once("../includes/controller.php");
//  require_once("../autoloader.php");
/*
  include_once("../classes/Database/Database.php");
  include_once("../classes/Models/User.php");*/



  if(isset($_SESSION['user_id']) && $_SESSION['role'] === "Administrator") {
    $title = "Zaposleni";


    include_once("../includes/partials/header.php");
    include_once("../includes/partials/navigation.php");

    $positionsController = new \Controllers\PositionController();
    $userController = new \Controllers\UserController();
    $filterValue = "all";
    if(isset($_SESSION['filterVal'])) {
      $filterValue = $_SESSION['filterVal'];
      if($filterValue !== "all") {
        $filterValue = $positionsController->getPositionNameById($filterValue);
      }

    }

//  echo $require_test;
    $positionsArr = $positionsController->getAllPositions();
    $usersArr = $userController->getUsersByFilteredData($filterValue);

    ?>
    <div class="container">

      <form action="../includes/controller.php" method="POST">
        <select name="positions">
          <option value="all">All</option>
          <?php foreach($positionsArr as $position): ?>
            <option value="<?= $position['position_id'] ?>"><?= $position['position_name']; ?></option>
          <?php endforeach; ?>
        </select>
        <button type="submit" name="positionFilter">Refresh</button>
      </form>


      <table>
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
              <td>
                <form action="./editEmployee.php" method="POST">
                  <input type="hidden" name="targetEmpoyeeId" value="<?= $user['employee_id']; ?>">
                  <button type="submit" name="editEmployee">Edit</button>
                  <button type="submit" name="deleteEmployee">Delete</button>
                </form>

              </td>

            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>

      <?php
        var_dump($usersArr);
      ?>
    </div>
    <?php
//  require_once("../includes/controller.php");



    include_once("../includes/partials/footer.php");
  } else {
    header("Location: ../index.php");
  }



