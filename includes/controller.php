<?php


  include_once("../autoloader.php");

/*  include_once("../classes/Database/Database.php");
  include_once("../classes/Models/User.php");
  include_once("../classes/Controllers/UserController.php");
  include_once("../classes/Controllers/LoginController.php");*/
  use Models\User;
  use Models\Position;
  use Controllers\LoginController;
  use Controllers\UserController;
  use Controllers\PositionController;


//  var_dump($_POST['login'], $_POST['email'], $_POST['password']);
//  $userController = new UserController();

  if(isset($_POST['login'])) {
    $email = checkData($_POST['email']);
    $password = checkData($_POST['password']);
    $userLogData = new LoginController($email, $password);
    $userLogData->handleLogin();
  }

  if(isset($_POST['positionFilter'])) {
    $getEmployeesByRole = $_POST['positions'];
    session_start();

    $_SESSION['filterVal'] = $getEmployeesByRole;
    unset($_POST['positionFilter']);
    var_dump($_SESSION['filterVal']);

    header("Location: ../dashboard/employees.php");
  }

  if(isset($_POST['deleteEmployee']) && $_SERVER["REQUEST_METHOD"] == "POST") {
    $employeeId = (int)$_POST['targetEmployeeId'];
    // @TODO: Convert to static Call
    UserController::deleteUser($employeeId);
  }

  if(isset($_POST['editUser'])) {
    var_dump($_POST['editUserId'],$_POST['fname'], $_POST['lname'], $_POST['editPositionsId'], $_POST['editSalary'], $_POST['editEmail']);
    $userId = (int) checkData($_POST['editUserId']);
    $editFirstName = checkData($_POST['fname']);
    $editLastName = checkData($_POST['lname']);
    $editPositionsId = (int) checkData($_POST['editPositionsId']);
    $editSalary = (float) checkData($_POST['editSalary']);
    $editEmail = checkData($_POST['editEmail']);

    $updateResult = UserController::editUserControllerData($userId, $editPositionsId, $editFirstName, $editLastName, $editSalary, $editEmail);
    if($updateResult) {
      // @TODO: Convert to static Call
      UserController::setUpdateSession("Sucesfully updated $editFirstName $editLastName");
    } else {
      UserController::setUpdateSession("Error updating $editFirstName $editLastName");
    }
    header("Location: ../dashboard/employees.php");
  }

  if($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['createUser'])) {


    $createFirstName = checkData($_POST['fname']);
    $createLastName = checkData($_POST['lname']);
    $createPositionsId = (int) checkData($_POST['createPositionsId']);
    $createSalary =(float) checkData($_POST['createSalary']);
    $createEmail = checkData($_POST['createEmail']);

    if(empty($createFirstName)) {
      // @TODO: Convert to static call
      UserController::setCreateUserErrorData("invalidNameEmpty", "Please fill name field");
    }
    if(empty($createLastName)) {
      // @TODO: Convert to static call
      UserController::setCreateUserErrorData("invalidLastEmpty", "Please fill last name field");
    }
    // Otherwise its converted and returns false
    if(empty($_POST['createSalary'])) {
      // @TODO: Convert to static call
      UserController::setCreateUserErrorData("invalidSalaryEmpty", "Please fill salary field");
    }
    if(empty($createEmail)) {
      // @TODO: Convert to static call
      UserController::setCreateUserErrorData("invalidEmailEmpty", "Please fill email field");
    }

    // @TODO: Convert to static call
    if(!is_float($createSalary) || !is_numeric($createSalary) || UserController::validateIfInputIsString($_POST['createSalary'])) {
      // bugcheck, more like sanity check
      $salaryType = gettype(checkData($_POST['createSalary']));
      UserController::setCreateUserErrorData("invalidSalaryType", "Please enter a numeric value, $salaryType given");
    }
//    var_dump(UserController::getCreateUserErrorData());
    // @TODO: Convert to static call
    UserController::createUser($createFirstName, $createLastName, $createPositionsId, $createEmail, $createSalary);
//    var_dump($result);
//    var_dump($userController->getCreateUserErrorData());
  }


/**
 * Helper function that cleans input data
 * @param $data
 * @return string
 */
  function checkData($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }
