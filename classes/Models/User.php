<?php

  namespace Models;

  use Database\Database;


  class User
  {


    protected array $errorData = [];
    protected array $loginData = [];
    public array $userData = [];

    /**
     * login function sets array property of login data,
     * and returns bool value if it finds user
     * @TODO Convert login function to boolean
     * @param $email
     * @param $password
     * @return bool
     */
    public function login($email, $password): bool
    {
      $password = md5($password);
      try {
        $db = Database::connect();
        $sql = "SELECT p.position_name as position_name, e.id as employee_id, e.firstname as firstname, e.lastname as lastname, e.salary as salary, e.email as email
            FROM employees e
         LEFT JOIN position p on e.position_id = p.id
        WHERE e.email= :email AND e.password= :password AND position_name='Administrator';";
        $statement = $db->prepare($sql);
        $statement->bindParam(":email", $email, \PDO::PARAM_STR);
        $statement->bindParam(":password", $password, \PDO::PARAM_STR);

        $statement->execute();
        if($statement->rowCount() > 0) {
          $result = $statement->fetch();
          $user_id = $result['employee_id'];
          $user_role = $result['position_name'];
          $this->loginData = [
            "user_id" => $user_id,
            "user_role" =>$user_role
          ];
          return true;
        } else {
          return false;
        }

      } catch (\PDOException $e) {
        return $e->getMessage();
      }
    }

    /**
     * Get login data
     * @return array
     */
    public function getLoginData(): array
    {
      return $this->loginData;
    }




    protected function getLoggedUserEmail($user_id): string
    {
      try {
        $sql = "SELECT e.email as email FROM employees e
                        LEFT JOIN position p on e.position_id = p.id
                        WHERE e.id=:user_id AND p.position_name='Administrator' ;";
        $statement = Database::connect()->prepare($sql);
        $statement->bindParam(":user_id", $user_id, \PDO::PARAM_INT);
        $statement->execute();

        if($statement->rowCount() > 0) {
          $result = $statement->fetch();
          return $result['email'];
        } else {
          return "Triggered Karen at the getLoggedUserEmail class";
        }

      } catch (\PDOException $e) {
        return $e->getMessage();
      }
    }

    protected function getSingleUserByIdData($user_id): array
    {
      try {
        $sql = "SELECT p.position_name as position_name, e.id as employee_id, e.firstname as firstname, e.lastname as lastname, e.salary as salary, e.email as email
                FROM employees e
                LEFT JOIN position p on e.position_id = p.id
                WHERE e.id=:user_id";
        $statement = Database::connect()->prepare($sql);
        $statement->bindParam(":user_id", $user_id, \PDO::PARAM_INT);
        $statement->execute();

        if($statement->rowCount() > 0) {
          $results = $statement->fetchAll();
          return $results[0];
        } else {
          return ["Triggered Karen at the getSingleUserById class"];
        }

      } catch (\PDOException $e) {
        return ["Error" => "$user_id error!: ". $e->getMessage()];
      }
    }

    protected function getAllUsersData(): array
    {
      $sql = "SELECT p.position_name as position_name, e.id as employee_id, e.firstname as firstname, e.lastname as lastname, e.salary as salary, e.email as email
            FROM employees e
         LEFT JOIN position p on e.position_id = p.id ORDER BY salary DESC";
      $db = Database::connect();
      $statement = $db->prepare($sql);

      $statement->execute();
      $results = $statement->fetchAll();
      return $results;
    }

    protected function getUsersByPositionNameData(string $filterPosition): array
    {
      $sql = "SELECT p.position_name as position_name, e.id as employee_id, e.firstname as firstname, e.lastname as lastname, e.salary as salary, e.email as email
            FROM employees e
         LEFT JOIN position p on e.position_id = p.id
        WHERE position_name=:filterPosition ORDER BY salary DESC;";
      $statement = Database::connect()->prepare($sql);
      $statement->bindParam(":filterPosition", $filterPosition);
      $statement->execute();
      if($statement->rowCount() > 0) {
        $results = $statement->fetchAll();
        return $results;
      } else {
        $results = ["There are no users $filterPosition"];
        return $results;
      }
    }



    /**
     * Validates email and checks if it exists in the database
     * @param $email
     * @return bool
     */
    public function checkEmailExists($email): bool
    {
      if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $this->setLoginErrorData("invalidEmail", "Invalid email");
        return false;
      }
      $sql = "SELECT email FROM employees WHERE email= :email";
      $statement = Database::connect()->prepare($sql);
      $statement->bindParam(":email", $email, \PDO::PARAM_STR);

      $statement->execute();

      if($statement->rowCount() > 0) {
        return true;
      } else {
        $this->setLoginErrorData("emailNotFoundError", "Searched email is not found");
        return false;
      }
    }

    public function checkValidPassword($email, $password): bool
    {
      $password = md5($password);
      $sql = "SELECT email FROM employees WHERE email= :email AND password=:password";
      $statement = Database::connect()->prepare($sql);
      $statement->bindParam(":email", $email, \PDO::PARAM_STR);
      $statement->bindParam(":password", $password, \PDO::PARAM_STR);

      $statement->execute();

      if($statement->rowCount() > 0) {
        return true;
      } else {
        $this->setLoginErrorData("passwordError", "Wrong Password!");
        return false;
      }
    }

    public function setLoginErrorData(string $targetKey,string $targetValue)
    {
      $this->errorData[$targetKey] = $targetValue;
    }

    public function getErrorData(): array
    {
      return $this->errorData;
    }

  }