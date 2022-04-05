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
    protected array $createErrorData = [];

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


    public function getLoggedUserInfo($user_id): array
    {
//      $this->setUserDataArr($this->getLoggedUserData($user_id));
      return $this->getLoggedUserData($user_id);
    }

/*    public function getLoggedUserInfo($user_id): array
    {
//      $this->setUserDataArr($this->getLoggedUserData($user_id));
      return $this->getLoggedUserData($user_id);
    }*/

    public function getUsersByFilteredData($filter): array {
      if($filter === "all") {
        return $this->getAllUsersData();
      } else {
        return $this->getUsersByPositionNameData($filter);
      }
    }

    public function getNumberOfEmployees(): int | string
    {
      return $this->getTotalNumberOfEmployees();
    }

    public function getAverageSalary(): array
    {
      return $this->getAverageSalaryData();
    }

    public function getGroupedEmployeeData(): array
    {
      return $this->getNumberOfEmplyeesPerPositionData();
    }

    public function getSingleUserById($user_id): array
    {
      return $this->getSingleUserByIdData($user_id);
    }

    // $_POST['fname'], $_POST['lname'], $_POST['editPositionsId'], $_POST['editSalary'], $_POST['editEmail']
    public function editUserControllerData(int $editUserId, int $editPositionsId, string $firstName, string $lastName, float $editSalary, string $editEmail): bool
    {
      return $this->editUserData( $editUserId, $editPositionsId, $firstName, $lastName, $editSalary, $editEmail);

    }

    public function setUpdateSession(string $message)
    {
      $_SESSION['update_result'] = $message;
    }

    public function deleteUser(int $userId) {
      if($this->deleteUserData($userId)) {
        header("Location: ../dashboard/employees.php");
      }

    }

    public function createUser(string $createFirstName, string $createLastName, int $createPositionsId, string $createEmail,float $createSalary)
    {

      // Email error
      if (!empty($createEmail) && !$this->validateEmail($createEmail)) {
        $this->setCreateUserErrorData("invalidEmail", "Please enter a valid email");
      }

      if(!empty($createEmail) && $this->checkUserDataEmailExists($createEmail)) {
        $this->setCreateUserErrorData("invalidEmailExists", "This email exists");
      }

      // Firstname error
      if (!empty($createFirstName) && !$this->validateIfInputIsString($createFirstName)) {
        $this->setCreateUserErrorData("invalidFirstName", "Name must contain only letters");
      }
      if (!empty($createFirstName) && $this->validateIfStringHasMultipleWords($createFirstName)) {
        $this->setCreateUserErrorData("invalidFirstNameMulti", "Name has multiple words");
      }
      if (!empty($createFirstName) && !$this->validateIfStringIsUppercase($createFirstName)) {
        $this->setCreateUserErrorData("invalidFirstNameCapital", "Name must be capitalised");
      }

      if (!empty($createFirstName) && strlen($createFirstName) < 5) {
        $this->setCreateUserErrorData('invalidFirstNameLength', "Name must contain more than 5 characters");
      }

      // Lastname error
      if (!empty($createLastName) && !$this->validateIfInputIsString($createLastName)) {
        $this->setCreateUserErrorData("invalidLastName", "Last name must contain only letters");
      }

      if (!empty($createLastName) && !$this->validateIfStringIsUppercase($createLastName)) {
        $this->setCreateUserErrorData("invalidLastNameCapital", "Last name must be capitalised");
      }

      if (!empty($createLastName) && strlen($createLastName) < 5) {
        $this->setCreateUserErrorData('invalidLastNameLength', "Last name must contain more than 5 characters");
      }


      var_dump($this->getCreateUserErrorData());

      if(!empty($this->getCreateUserErrorData())) {
        $this->setSessionCreateUserError();
        header("Location: ../dashboard/createEmployee.php");
      } else {
        $this->createUserData($createFirstName, $createLastName, $createPositionsId, $createSalary, $createEmail);
        header("Location: ../dashboard/employees.php");
      }


    }

    // Create User Error functions

    public function setCreateUserErrorData(string $targetKey,string $targetValue)
    {
      $this->createErrorData[$targetKey] = $targetValue;
    }

    public function getCreateUserErrorData(): array
    {
      return $this->createErrorData;
    }

    public function setSessionCreateUserError()
    {
      $errors = $this->getCreateUserErrorData();
      $_SESSION['create_user_errors'] = $errors;
    }

    // Helper validation functions

    public function validateEmail(string $email): bool
    {
      if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return false;
      }
      return true;
    }

    public function validateIfInputIsString(string $checkString): bool
    {
      if(!preg_match("/^[a-z]+$/i", $checkString)) {
        return false;
      }
      return true;
    }

    public function validateIfStringIsUppercase(string $checkString): bool
    {
      if(!preg_match('~^\p{Lu}~u', $checkString)) {
        return false;
      }
      return true;
    }

    public function validateIfStringHasMultipleWords(string $checkString): bool
    {
      if (!preg_match("/^[^ ].* .*[^ ]$/", $checkString))
      {
        return false;
      }
      return true;
    }







  }