<?php

  namespace Controllers;

  if(!isset($_SESSION))
  {
    session_start();
  }
  use Models\User;

  class LoginController extends User
  {
    protected array $loginData = [];
    protected array $errorData = [];


    public function getLoggedUser($email, $password)
    {
//        $this->login($email, $password);
      if($this->login($email, $password)) {
        $loginData = $this->getLoginData();
        $this->createSession($loginData['user_id'], $loginData['user_role']);
        header("Location: ../dashboard/dashboard.php");
      } else {
        $this->setLoginErrorData("emailPasswordErr", 'Email/Password error!');
        header("Location: ../index.php");
      }

    }

    public function checkValidEmail(string $email): bool
    {
      if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
//        $this->setLoginErrorData("invalidEmail", "Invalid email");
        return false;
      }
      return true;
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

    /**
     * Get login data
     * @return array
     */
    public function getLoginData(): array
    {
      return $this->loginData;
    }

    public function checkEmailExists(string $email): bool
    {
      return $this->checkUserDataEmailExists($email);
    }

    public function checkValidPassword(string $email, string $password): bool
    {
      return $this->checkUserValidPassword($email, $password);
    }

    public function getErrorData(): array
    {
      return $this->errorData;
    }

    /**
     * @param string $targetKey
     * @param string $targetValue
     */
    public function setLoginErrorData(string $targetKey,string $targetValue)
    {
      $this->errorData[$targetKey] = $targetValue;
    }
  }