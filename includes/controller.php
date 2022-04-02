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

  if(isset($_POST['login'])) {
    if(isset($_POST['login']) && !empty($_POST['email']) && !empty($_POST['password'])) {

      $email = checkData($_POST['email']);
      $password = checkData($_POST['password']);
//    $userLogData->checkEmailExists($email);
      if($userLogData->checkEmailExists($email) && $userLogData->checkValidPassword($email, $password)) {
        echo "Test";
        echo "Uspeh:";
        $result = $userLogData->getLoggedUser($email, $password);
        var_dump($result);
      } else  {
        $userLogData->setSessionLoginError();
        var_dump($_SESSION);
        header("Location: ../index.php");
      }

    } else if (empty($_POST['email']) && empty($_POST['password'])) {
      $userLogData->setLoginErrorData("emailPasswordErr", "Triggered Karen");
      $userLogData->setLoginErrorData("emptyEmailError", "Empty email error");
      $userLogData->setLoginErrorData("emptyPasswordError", "Empty password error");

      $userLogData->setSessionLoginError();

      var_dump($_SESSION);

      header("Location: ../index.php");
    } else if (empty($_POST['email']) ) {
      $userLogData->setLoginErrorData("emptyEmailError", "Empty email error");

      $userLogData->setSessionLoginError();
      var_dump($_SESSION);

      header("Location: ../index.php");
    } else if (empty($_POST['password'])) {
      $userLogData->setLoginErrorData("emptyPasswordError", "Empty password error");

      $userLogData->setSessionLoginError();

      var_dump($_SESSION);

      header("Location: ../index.php");
    }
  }

  if(isset($_POST['positionFilter'])) {
    $getEmployeesByRole =  $_POST['positions'];

    $_SESSION['filterVal'] = $getEmployeesByRole;
    unset($_POST['positionFilter']);
    header("Location: ../dashboard/employees.php");
  }

  if(isset($_POST['editUser'])) {
    var_dump($_POST['fname'], $_POST['lname'], $_POST['editPositions'], $_POST['editSalary'], $_POST['editEmail']);
  }


  function checkData($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }
