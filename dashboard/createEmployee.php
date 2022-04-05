<?php

  if(!isset($_SESSION)) {
    session_start();
  }

//  include_once("../includes/controller.php");
//  require_once("../autoloader.php");
  /*
    include_once("../classes/Database/Database.php");
    include_once("../classes/Models/User.php");*/

  if (!isset($_SESSION['user_id']) && $_SESSION['role'] !== "Administrator") {
    header("Location: ../index.php");
  }


  if(isset($_SESSION['user_id']) && $_SESSION['role'] === "Administrator") {
    $title = "Add Employee";

    include_once("../includes/partials/header.php");
    include_once("../includes/partials/navigation.php");

    $positionsController = new \Controllers\PositionController();
    $positionsArr = $positionsController->getAllPositions();

    $createUserErrorMessages = [];
    if(isset($_SESSION['create_user_errors'])) {
      $createUserErrorMessages = $_SESSION['create_user_errors'];
      unset($_SESSION['create_user_errors']);
    }
    ?>
    <section class="login-section">
      <div class="container flex">
        <h1>Add New Employee</h1>
        <form action="../includes/controller.php" method="POST" class="form">
          <div class="form-control">
            <label for="fname">
              <span>First name:</span>
              <input type="text" name="fname" id="fname">
              <?php
                echo "<span class='input-error'> ";
                echo (isset($createUserErrorMessages['invalidNameEmpty'])) ?  $createUserErrorMessages['invalidNameEmpty'] : "";
                echo (isset($createUserErrorMessages['invalidFirstName'])) ?  $createUserErrorMessages['invalidFirstName']."<br>" : "";
                echo (isset($createUserErrorMessages['invalidFirstNameMulti'])) ?  $createUserErrorMessages['invalidFirstNameMulti']."<br>" : "";
                echo (isset($createUserErrorMessages['invalidFirstNameCapital'])) ?  $createUserErrorMessages['invalidFirstNameCapital']."<br>" : "";
                echo (isset($createUserErrorMessages['invalidFirstNameLength'])) ?  $createUserErrorMessages['invalidFirstNameLength']."<br>" : "";

                echo "</span>"
              ?>
            </label>
          </div>
          <div class="form-control">
            <label for="lname">
              <span>Last name:</span>
              <input type="text" name="lname" id="lname">
              <?php
                echo "<span class='input-error'> ";
                echo (isset($createUserErrorMessages['invalidLastEmpty'])) ?  $createUserErrorMessages['invalidLastEmpty'] : "";
                echo (isset($createUserErrorMessages['invalidLastName'])) ?  $createUserErrorMessages['invalidLastName']."<br>" : "";
                echo (isset($createUserErrorMessages['invalidLastNameCapital'])) ?  $createUserErrorMessages['invalidLastNameCapital']."<br>" : "";
                echo (isset($createUserErrorMessages['invalidLastNameLength'])) ?  $createUserErrorMessages['invalidLastNameLength']."<br>" : "";

                echo "</span>"
              ?>
            </label>
          </div>
          <div class="form-control">
            <label for="editPositionsId">
              <span>Select Employee Position: </span>
              <select name="createPositionsId" id="editPositionsId">
                <?php foreach($positionsArr as $position): ?>
                  <?php
                    if($position['position_name'] === "Administrator") {
                      continue;
                    }
                  ?>
                  <option value="<?= $position['position_id'] ?>"><?= $position['position_name']; ?></option>
                <?php endforeach; ?>
              </select>
            </label>
          </div>
          <div class="form-control">
            <label for="createSalary">
              <span>Salary:</span>
              <input type="text" name="createSalary" id="createSalary">
              <?php
                echo "<span class='input-error'> ";
                echo (isset($createUserErrorMessages['invalidSalaryEmpty'])) ?  $createUserErrorMessages['invalidSalaryEmpty'] : "";
                echo (isset($createUserErrorMessages['invalidSalaryType'])) ?  $createUserErrorMessages['invalidSalaryType']."<br>" : "";

                echo "</span>"
              ?>
            </label>
          </div>
          <div class="form-control">
            <label for="editEmail">
              <span>Email:</span>
              <input type="text" name="createEmail" id="createEmail">
              <?php
                echo "<span class='input-error'> ";
                echo (isset($createUserErrorMessages['invalidEmailEmpty'])) ?  $createUserErrorMessages['invalidEmailEmpty'] : "";
                echo (isset($createUserErrorMessages['invalidEmail'])) ?  $createUserErrorMessages['invalidEmail']."<br>" : "";
                echo (isset($createUserErrorMessages['invalidEmailExists'])) ?  $createUserErrorMessages['invalidEmailExists']."<br>" : "";

                echo "</span>"
              ?>
            </label>
          </div>

          <button type="submit" class="btn btn-submit"  name="createUser">Add new Employee</button>
          <?php
            //              var_dump($singleEditUser);
          ?>
        </form>




      </div>
    </section>

    <?php
    include_once("../includes/partials/footer.php");
//    isset($_SESSION['user_id']) && $_SESSION['role'] === "Administrator"
  } else {
    header("Location: ../index.php");
  }