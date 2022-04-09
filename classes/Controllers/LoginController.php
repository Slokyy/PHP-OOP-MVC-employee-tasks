<?php

  namespace Controllers;

  if(!isset($_SESSION))
  {
    session_start();
  }
  use Models\User;

  class LoginController extends User
  {
    private string $loginEmail;
    private string $loginPassword;
    protected string $loginUserId;
    protected string $loginUserRole;
    protected array $errorData = [];

    /**
     * Construct setter for login and password
     * @param $email
     * @param $password
     */
    public function __construct($email, $password)
    {
      $this->loginEmail = $email;
      $this->loginPassword = md5($password);
    }

    /**
     * Setter method for logged user Id
     * @param int $loginUserId
     * @return void
     */
    public function setLoginUserId(int $loginUserId): void
    {
      $this->loginUserId = $loginUserId;
    }

    /**
     * Getter method for logged user Id
     * @return int
     */
    public function getLoginUserId(): int
    {
      return $this->loginUserId;
    }

    /**
     * Setter method for setting logged user Role
     * @param string $loginUserRole
     * @return void
     */
    public function setLoginuserRole(string $loginUserRole): void
    {
      $this->loginUserRole = $loginUserRole;
    }

    /**
     * Getter method that returns logged user role
     * @return string
     */
    public function getLoginUserRole(): string
    {
      return $this->loginUserRole;
    }

    /**
     * Setter for logged user email
     * @param string $email
     * @return void
     */
    public function setLoginEmail(string $email): void
    {
      $this->loginEmail = $email;
    }

    /**
     * getter for logged user email
     * @return string
     */
    public function getLoginEmail(): string
    {
      return $this->loginEmail;
    }

    /**
     * Setter for logged user password
     * @param string $password
     * @return void
     */
    public function setLoginPassword(string $password): void
    {
      $this->loginPassword = $password;
    }

    /**
     * Getter for login user password
     * @return string
     */
    public function getLoginPassword(): string
    {
      return $this->loginPassword;
    }



    /**
     * Handler method for login
     * @return void
     */
    public function handleLogin(): void
    {
      if(isset($_POST['login']) && !empty($_POST['email']) && !empty($_POST['password'])) {

        if($this->checkValidEmail()) {
          if($this->checkEmailExists() && $this->checkValidPassword()) {

            echo "Uspeh:";


            var_dump($this->loginEmail, $this->loginPassword);
            $this->getLoggedUser();
          } else if (!$this->checkEmailExists()) {
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
          $this->setSessionLoginError();
          var_dump($_SESSION['login_errors'], $this->loginEmail);
        }

      } else if (empty($_POST['email']) && empty($_POST['password'])) {
        $this->setLoginErrorData("emailPasswordErr", "Empty form");
        $this->setLoginErrorData("emptyEmailError", "Empty email error");
        $this->setLoginErrorData("emptyPasswordError", "Empty password error");

        $this->setSessionLoginError();

        header("Location: ../index.php");
      } else if (empty($_POST['email'])) {
        $this->setLoginErrorData("emptyEmailError", "Empty email error");

        $this->setSessionLoginError();

        header("Location: ../index.php");
      } else if (empty($_POST['password'])) {
        $this->setLoginErrorData("emptyPasswordError", "Empty password error");

        $this->setSessionLoginError();

        header("Location: ../index.php");
      }
      var_dump($this->getErrorData());
    }

    /**
     * Helper getter function that passes email and password verifys user login info
     * @return void
     */
    public function getLoggedUser(): void
    {
      if($this->login($this->loginEmail, $this->loginPassword)) {
        echo "true";
        $this->setLoginUserId($this->getLoginData()['user_id']);
        $this->setLoginUserRole($this->getLogindata()['user_role']);
        $this->createSession();
        header("Location: ../dashboard/dashboard.php");
      } else {
        $this->setLoginErrorData("emailPasswordErr", 'Email/Password error!');
        header("Location: ../index.php");
      }

    }



    /**
     * Function creates session for loggin
     * @return void
     */
    public function createSession(): void
    {
      if(!isset($_SESSION))
      {
        session_start();
      }

      $_SESSION['user_id'] = $this->getLoginUserId();
      $_SESSION['role'] = $this->getLoginUserRole();
    }

    /**
     * Error login session
     * @return void
     */
    public function setSessionLoginError(): void
    {
      if(!isset($_SESSION))
      {
        session_start();
      }
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
     * @return bool
     */
    public function checkValidEmail(): bool
    {
      if(!filter_var($this->getLoginEmail(), FILTER_VALIDATE_EMAIL)) {
        $this->setLoginErrorData("invalidEmail", "Invalid email");
        return false;
      }
      return true;
    }

    /**
     * Getter function that chacks if email exists in employees table
     * @return bool
     */

    public function checkEmailExists(): bool
    {
      return $this->checkUserDataEmailExists($this->getLoginEmail());
    }

    /**
     * Checker function that runs model function and returns bool on validity of password
     * @return bool
     */
    public function checkValidPassword(): bool
    {
      return $this->checkUserValidPassword($this->getLoginEmail(), $this->getLoginPassword());
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
     * setting Error Data
     * @param string $targetKey
     * @param string $targetValue
     * @return void
     */
    public function setLoginErrorData(string $targetKey,string $targetValue): void
    {
      $this->errorData[$targetKey] = $targetValue;
    }
  }
