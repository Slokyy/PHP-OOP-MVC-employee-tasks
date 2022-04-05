<?php

  namespace Controllers;

  use Models\User;

  class UserController extends User
  {
    public string $userRole;
    public string $userName;
    public string $userLastName;
    public string $userEmail;
    public array $userDataArr;
    public static array $createErrorData = [];

    public function __construct(int $userId = 0)
    {
      $this->setUserDataArr($this->getLoggedUserData($userId));
      $this->userName = $this->getUserDataArr()['firstname'];
      $this->userLastName = $this->getUserDataArr()['lastname'];
      $this->userEmail = $this->getUserDataArr()['email'];
      $this->userRole = $this->getUserDataArr()['position_name'];
    }

    /**
     * @return string
     */
    public function getUserRole(): string
    {
      return $this->userRole;
    }

    /**
     * @param string $userRole
     */
    public function setUserRole(string $userRole): void
    {
      $this->userRole = $userRole;
    }

    /**
     * @return string
     */
    public function getUserName(): string
    {
      return $this->userName;
    }

    /**
     * @param string $userName
     */
    public function setUserName(string $userName): void
    {
      $this->userName = $userName;
    }

    /**
     * @return string
     */
    public function getUserLastName(): string
    {
      return $this->userLastName;
    }

    /**
     * @param string $userLastName
     */
    public function setUserLastName(string $userLastName): void
    {
      $this->userLastName = $userLastName;
    }

    /**
     * @return string
     */
    public function getUserEmail(): string
    {
      return $this->userEmail;
    }

    /**
     * @param string $userEmail
     */
    public function setUserEmail(string $userEmail): void
    {
      $this->userEmail = $userEmail;
    }



    public function setUserDataArr(array $userData) {
      $this->userDataArr = $userData;
    }

    public function getUserDataArr()
    {
      return $this->userDataArr;
    }


    public function getUsersByFilteredData($filter): array {
      if($filter === "all") {
        return $this->getAllUsersData();
      } else {
        return $this->getUsersByPositionNameData($filter);
      }
    }



    public function getSingleUserById($user_id): array
    {
      return $this->getSingleUserByIdData($user_id);
    }

    // $_POST['fname'], $_POST['lname'], $_POST['editPositionsId'], $_POST['editSalary'], $_POST['editEmail']
    public static function editUserControllerData(int $editUserId, int $editPositionsId, string $firstName, string $lastName, float $editSalary, string $editEmail): bool
    {
      return (new parent)->editUserData( $editUserId, $editPositionsId, $firstName, $lastName, $editSalary, $editEmail);

    }

    public static function setUpdateSession(string $message)
    {
      $_SESSION['update_result'] = $message;
    }

    public static function deleteUser(int $userId) {
      if((new parent)->deleteUserData($userId)) {
        header("Location: ../dashboard/employees.php");
      }

    }

    public static function createUser(string $createFirstName, string $createLastName, int $createPositionsId, string $createEmail,float $createSalary)
    {

      // Email error
      if (!empty($createEmail) && !self::validateEmail($createEmail)) {
        self::setCreateUserErrorData("invalidEmail", "Please enter a valid email");
      }

      if(!empty($createEmail) && (new parent)->checkUserDataEmailExists($createEmail)) {
        self::setCreateUserErrorData("invalidEmailExists", "This email exists");
      }

      // Firstname error
      if (!empty($createFirstName) && !self::validateIfInputIsString($createFirstName)) {
        self::setCreateUserErrorData("invalidFirstName", "Name must contain only letters");
      }
      if (!empty($createFirstName) && self::validateIfStringHasMultipleWords($createFirstName)) {
        self::setCreateUserErrorData("invalidFirstNameMulti", "Name has multiple words");
      }
      if (!empty($createFirstName) && !self::validateIfStringIsUppercase($createFirstName)) {
        self::setCreateUserErrorData("invalidFirstNameCapital", "Name must be capitalised");
      }

      if (!empty($createFirstName) && strlen($createFirstName) < 5) {
        self::setCreateUserErrorData('invalidFirstNameLength', "Name must contain more than 5 characters");
      }

      // Lastname error
      if (!empty($createLastName) && !self::validateIfInputIsString($createLastName)) {
        self::setCreateUserErrorData("invalidLastName", "Last name must contain only letters");
      }

      if (!empty($createLastName) && !self::validateIfStringIsUppercase($createLastName)) {
        self::setCreateUserErrorData("invalidLastNameCapital", "Last name must be capitalised");
      }

      if (!empty($createLastName) && strlen($createLastName) < 5) {
        self::setCreateUserErrorData('invalidLastNameLength', "Last name must contain more than 5 characters");
      }




      if(!empty(self::getCreateUserErrorData())) {
        self::setSessionCreateUserError();
        var_dump($_SESSION['create_user_errors']);

        header("Location: ../dashboard/createEmployee.php");
      } else {
        (new parent)->createUserData($createFirstName, $createLastName, $createPositionsId, $createSalary, $createEmail);
        header("Location: ../dashboard/employees.php");
      }


    }

    // Create User Error functions

    public static function setCreateUserErrorData(string $targetKey,string $targetValue)
    {
      self::$createErrorData[$targetKey] = $targetValue;
    }

    public static function getCreateUserErrorData(): array
    {
      return self::$createErrorData;
    }

    public static function setSessionCreateUserError()
    {
      session_start();

//      var_dump($errors);
      $_SESSION['create_user_errors'] = self::getCreateUserErrorData();
    }

    // Helper validation functions

    public static function validateEmail(string $email): bool
    {
      if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return false;
      }
      return true;
    }

    public static function validateIfInputIsString(string $checkString): bool
    {
      if(!preg_match("/^[a-z]+$/i", $checkString)) {
        return false;
      }
      return true;
    }

    public static function validateIfStringIsUppercase(string $checkString): bool
    {
      if(!preg_match('~^\p{Lu}~u', $checkString)) {
        return false;
      }
      return true;
    }

    public static function validateIfStringHasMultipleWords(string $checkString): bool
    {
      if (!preg_match("/^[^ ].* .*[^ ]$/", $checkString))
      {
        return false;
      }
      return true;
    }







  }