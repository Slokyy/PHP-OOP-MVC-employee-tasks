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
  $userLogData = new LoginController();
  $userController = new UserController();

  if(isset($_POST['login'])) {
    if(isset($_POST['login']) && !empty($_POST['email']) && !empty($_POST['password'])) {

      $email = checkData($_POST['email']);
      $password = checkData($_POST['password']);
//    $userLogData->checkEmailExists($email);
      if($userLogData->checkValidEmail($email)) {
        if($userLogData->checkEmailExists($email) && $userLogData->checkValidPassword($email, $password)) {
          echo "Test";
          echo "Uspeh:";
          $userLogData->getLoggedUser($email, $password);
//        var_dump($result);
        } else if (!$userLogData->checkEmailExists($email)) {
          $userLogData->setLoginErrorData("emailNotFoundError", "Searched email is not found");
          $userLogData->setSessionLoginError();
          header("Location: ../index.php");

        } else {
          $userLogData->setLoginErrorData("passwordError", "Wrong Password!");

          $userLogData->setSessionLoginError();
          var_dump($_SESSION);
          header("Location: ../index.php");
        }
      } else {
        $userLogData->setLoginErrorData("invalidEmail", "Invalid email");
//        session_start();
        $userLogData->setSessionLoginError();
        var_dump($_SESSION['login_errors'], $email);
        header("Location: ../index.php");
      }

    } else if (empty($_POST['email']) && empty($_POST['password'])) {
      $userLogData->setLoginErrorData("emailPasswordErr", "Triggered Karen");
      $userLogData->setLoginErrorData("emptyEmailError", "Empty email error");
      $userLogData->setLoginErrorData("emptyPasswordError", "Empty password error");

      $userLogData->setSessionLoginError();

      header("Location: ../index.php");
    } else if (empty($_POST['email']) ) {
      $userLogData->setLoginErrorData("emptyEmailError", "Empty email error");

      $userLogData->setSessionLoginError();

      header("Location: ../index.php");
    } else if (empty($_POST['password'])) {
      $userLogData->setLoginErrorData("emptyPasswordError", "Empty password error");

      $userLogData->setSessionLoginError();

      header("Location: ../index.php");
    }
  }

  if(isset($_POST['positionFilter'])) {
    $getEmployeesByRole =  $_POST['positions'];

    $_SESSION['filterVal'] = $getEmployeesByRole;
    unset($_POST['positionFilter']);
    header("Location: ../dashboard/employees.php");
  }

  if(isset($_POST['deleteEmployee']) && $_SERVER["REQUEST_METHOD"] == "POST") {
    $employeeId = (int)$_POST['targetEmployeeId'];
    $userController->deleteUser($employeeId);
  }

  if(isset($_POST['editUser'])) {
    var_dump($_POST['editUserId'],$_POST['fname'], $_POST['lname'], $_POST['editPositionsId'], $_POST['editSalary'], $_POST['editEmail']);
    $userId = (int) checkData($_POST['editUserId']);
    $editFirstName = checkData($_POST['fname']);
    $editLastName = checkData($_POST['lname']);
    $editPositionsId = (int) checkData($_POST['editPositionsId']);
    $editSalary = (float) checkData($_POST['editSalary']);
    $editEmail = checkData($_POST['editEmail']);

    $updateResult = $userController->editUserControllerData($userId, $editPositionsId, $editFirstName, $editLastName, $editSalary, $editEmail);
    if($updateResult) {
      $userController->setUpdateSession("Sucesfully updated $editFirstName $editLastName");
    } else {
      $userController->setUpdateSession("Error updating $editFirstName $editLastName");
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
      $userController->setCreateUserErrorData("invalidNameEmpty", "Please fill name field");
    }
    if(empty($createLastName)) {
      $userController->setCreateUserErrorData("invalidLastEmpty", "Please fill last name field");
    }
    // Otherwise its converted and returns false
    if(empty($_POST['createSalary'])) {
      $userController->setCreateUserErrorData("invalidSalaryEmpty", "Please fill salary field");
    }
    if(empty($createEmail)) {
      $userController->setCreateUserErrorData("invalidEmailEmpty", "Please fill email field");
    }

    if(!is_float($createSalary) || !is_numeric($createSalary) || $userController->validateIfInputIsString($_POST['createSalary'])) {
      // bugcheck, more like sanity check
      $salaryType = gettype(checkData($_POST['createSalary']));
      $userController->setCreateUserErrorData("invalidSalaryType", "Please enter a numeric value");
    }

    $userController->createUser($createFirstName, $createLastName, $createPositionsId, $createEmail, $createSalary);
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
