<?php

  if(!isset($_SESSION)) {
    session_start();
  }

//  include_once("../includes/controller.php");
//  require_once("../autoloader.php");
  /*
    include_once("../classes/Database/Database.php");
    include_once("../classes/Models/User.php");*/



  if(isset($_SESSION['user_id']) && $_SESSION['role'] === "Administrator" && isset($_POST['targetEmployeeId'])) {
    $title = "Edit";
    $targetEmployeeId = $_POST['targetEmployeeId'];

    include_once("../includes/partials/header.php");
    include_once("../includes/partials/navigation.php");

    $positionsController = new \Controllers\PositionController();
    $userController = new \Controllers\UserController();
    $singleEditUser = $userController->getSingleUserById($targetEmployeeId);
    $positionsArr = $positionsController->getAllPositions();
//    var_dump($singleEditUser);


    ?>
      <section class="login-section">
        <div class="container flex">
          <h1>Edit <?= $singleEditUser['firstname'] . " " . $singleEditUser['lastname'] ?></h1>
          <form action="../includes/controller.php" method="POST" class="form">
            <input type="hidden" name="editUserId" value="<?= $singleEditUser['employee_id'] ?>">
            <div class="form-control">
              <label for="fname">
                <span>First name:</span>
                <input type="text" name="fname" id="fname" value="<?= $singleEditUser['firstname']?>"><br>
              </label>
            </div>
            <div class="form-control">
              <label for="lname">
                <span>Last name:</span>
                <input type="text" name="lname" id="lname" value="<?= $singleEditUser['lastname']?>"><br>
              </label>
            </div>
            <div class="form-control">
              <label for="editPositionsId">
                <span>Position ( <?= $singleEditUser['position_name']?>):</span>

                <select name="editPositionsId" id="editPositionsId">
                  <option value="<?= $singleEditUser['position_id'] ?>" selected="selected"><?= $singleEditUser['position_name'] ?></option>
                  <?php if($singleEditUser['position_name'] !== "Administrator"): ?>
                    <?php foreach($positionsArr as $position): ?>
                      <?php
                        if($singleEditUser['position_name'] === $position['position_name']) {
                          continue;
                        }
                      ?>
                      <option value="<?= $position['position_id'] ?>"><?= $position['position_name']; ?></option>
                    <?php endforeach; ?>
                  <?php else: ?>
                    <option value="<?= $singleEditUser['position_id'] ?>"><?= $singleEditUser['position_name'] ?></option>
                  <?php endif; ?>
                </select>
              </label>
            </div>
            <div class="form-control">
              <label for="editSalary">
                <span>Salary:</span>
                <input type="text" name="editSalary" id="editSalary" value="<?= $singleEditUser['salary']?>"><br>
              </label>
            </div>
            <div class="form-control">
              <label for="editEmail">
                <span>Email:</span>
                <input type="email" name="editEmail" id="editEmail" value="<?= $singleEditUser['email']?>"><br>
              </label>
            </div>

            <button type="submit" class="btn btn-submit"  name="editUser">Edit</button>
            <?php
//              var_dump($singleEditUser);
            ?>
          </form>




        </div>
      </section>

    <?php
//  require_once("../includes/controller.php");



    include_once("../includes/partials/footer.php");
  } else if (isset($_SESSION['user_id']) && $_SESSION['role'] === "Administrator") {
    header("Location: ./employees.php");
  } else {
    header("Location: ../index.php");
  }