<?php

  namespace Controllers;

  if(!isset($_SESSION))
  {
    session_start();
  }
  use Models\User;

  class LoginController extends User
  {

    public function getLoggedUser($email, $password)
    {
      $this->login($email, $password);
      if($this->login($email, $password)) {
        $loginData = $this->getLoginData();
        $this->createSession($loginData['user_id'], $loginData['user_role']);
        header("Location: ../dashboard/dashboard.php");
      } else {
        $this->setLoginErrorData("emailPasswordErr", 'Email/Password error!');
        header("Location: ../index.php");
      }
    }

    public function createSession($user_id, $user_role)
    {
      if(!isset($_SESSION))
      {
        session_start();
      }

      $_SESSION['user_id'] = $user_id;
      $_SESSION['role'] = $user_role;
    }

    public function setSessionLoginError()
    {
      $errors = $this->getErrorData();
      $_SESSION['login_errors'] = $errors;
    }

  }