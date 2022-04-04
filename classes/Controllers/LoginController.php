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


    /**
     * login test
     * @test Testing user login
     */
    public function handleLogin() {
      if(isset($_POST['login']) && !empty($_POST['email']) && !empty($_POST['password'])) {

        $email = checkData($_POST['email']);
        $password = checkData($_POST['password']);
//    $userLogData->checkEmailExists($email);
        if($this->checkValidEmail($email)) {
          if($this->checkEmailExists($email) && $this->checkValidPassword($email, $password)) {
            echo "Test";
            echo "Uspeh:";
            $this->getLoggedUser($email, $password);
//        var_dump($result);
          } else if (!$this->checkEmailExists($email)) {
            $this->setLoginErrorData("emailNotFoundError", "Searched email is not found");
            $this->setSessionLoginError();
            header("Location: ../index.php");

          } else {
            $this->setLoginErrorData("passwordError", "Wrong Password!");

            $this->setSessionLoginError();
            var_dump($_SESSION);
            header("Location: ../index.php");
          }
        } else {
          $this->setLoginErrorData("invalidEmail", "Invalid email");
//        session_start();
          $this->setSessionLoginError();
          var_dump($_SESSION['login_errors'], $email);
          header("Location: ../index.php");
        }

      } else if (empty($_POST['email']) && empty($_POST['password'])) {
        $this->setLoginErrorData("emailPasswordErr", "Triggered Karen");
        $this->setLoginErrorData("emptyEmailError", "Empty email error");
        $this->setLoginErrorData("emptyPasswordError", "Empty password error");

        $this->setSessionLoginError();

        header("Location: ../index.php");
      } else if (empty($_POST['email']) ) {
        $this->setLoginErrorData("emptyEmailError", "Empty email error");

        $this->setSessionLoginError();

        header("Location: ../index.php");
      } else if (empty($_POST['password'])) {
        $this->setLoginErrorData("emptyPasswordError", "Empty password error");

        $this->setSessionLoginError();

        header("Location: ../index.php");
      }
    }

    /**
     * Helper getter function that passes email and password verifys user login info
     * @param $email
     * @param $password
     */
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



    /**
     * Function creates session for loggin
     * @param $user_id
     * @param $user_role
     */
    public function createSession($user_id, $user_role)
    {
      if(!isset($_SESSION))
      {
        session_start();
      }

      $_SESSION['user_id'] = $user_id;
      $_SESSION['role'] = $user_role;
    }

    /**
     * Error login session
     */
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

    /**
     * Email validator
     * @param string $email
     * @return bool
     */
    public function checkValidEmail(string $email): bool
    {
      if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
//        $this->setLoginErrorData("invalidEmail", "Invalid email");
        return false;
      }
      return true;
    }

    /**
     * Getter function that chacks if email exists in employees table
     * @param string $email
     * @return bool
     */

    public function checkEmailExists(string $email): bool
    {
      return $this->checkUserDataEmailExists($email);
    }

    /**
     * Checker function that runs model function and returns bool on validity of password
     * @param string $email
     * @param string $password
     * @return bool
     */
    public function checkValidPassword(string $email, string $password): bool
    {
      return $this->checkUserValidPassword($email, $password);
    }

    /**
     * Getter of error property
     * @return array
     */
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