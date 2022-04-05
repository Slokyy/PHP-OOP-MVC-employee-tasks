<?php

  namespace Models;

  use Database\Database;


  class User
  {
    protected array $loginData = [];


    /**
     * login function sets array property of login data,
     * and returns bool value if it finds user
     * @TODO Convert login function to boolean
     * @param string $email
     * @param string $password
     * @return bool
     */
    public function login(string $email, string $password): bool
    {
//      $password = md5($password);
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
     * PDO query to fill employee table with data
     * @param string $firstName
     * @param string $lastName
     * @param int $positionId
     * @param float $salary
     * @param string $email
     * @return bool
     */
    protected function createUserData(string $firstName, string $lastName,int $positionId,float $salary,string $email): bool
    {
      try {
        $sql = "INSERT INTO employees (position_id, firstname, lastname, salary, email)
                    VALUES ( :positionId, :firstName, :lastName, :salary, :email);";
        $statement =  Database::connect()->prepare($sql);
        $statement->bindParam(":positionId", $positionId, \PDO::PARAM_INT);
        $statement->bindParam(":firstName", $firstName, \PDO::PARAM_STR);
        $statement->bindParam(":lastName", $lastName, \PDO::PARAM_STR);
        $statement->bindParam(":salary", $salary);
        $statement->bindParam(":email", $email, \PDO::PARAM_STR);

        $statement->execute();
        if($statement->rowCount() > 0) {
          return true;
        } else {
          return false;
        }

      } catch (\PDOException $e) {
        return $e->getMessage();
      }
    }

    /**
     * PDO Edit query to edit certain user data
     * @param int $editUserId
     * @param int $editPositionsId
     * @param string $firstName
     * @param string $lastName
     * @param float $editSalary
     * @param string $editEmail
     * @return bool
     */
    protected function editUserData(int $editUserId, int $editPositionsId, string $firstName, string $lastName, float $editSalary, string $editEmail): bool
    {
      try {
        if(!filter_var($editEmail, FILTER_VALIDATE_EMAIL)) {
          throw new \PDOException("Invalid Email");
        }
        $sql = "UPDATE employees SET
                  position_id=:position_id,
                  firstname=:firstName,
                  lastname=:lastName,
                  salary=:salary,
                  email=:email
                    WHERE id=:editUserId";
        $statement = Database::connect()->prepare($sql);
        $statement->bindParam(":position_id", $editPositionsId);
        $statement->bindParam(":firstName", $firstName);
        $statement->bindParam(":lastName", $lastName);
        $statement->bindParam(":salary", $editSalary);
        $statement->bindParam(":email", $editEmail, );
        $statement->bindParam(":editUserId", $editUserId);
        $statement->execute();
        if($statement->rowCount() > 0) {
          return true;
        } else {
          return false;
        }

      } catch (\PDOException $e) {
        return "Error updating $editEmail!: ". $e->getMessage();
      }

    }

    /**
     * PDO query for deleting user by id
     * @param int $userId
     * @return bool
     */
    protected function deleteUserData(int $userId): bool
    {
      try {
        $sql = "DELETE FROM employees WHERE id=:id";
        $statement = Database::connect()->prepare($sql);
        $statement->bindParam(":id", $userId, \PDO::PARAM_INT);

        $statement->execute();
        if($statement->rowCount() > 0) {
          return true;
        } else {
          return false;
        }
      } catch (\PDOException $e) {
        return $e->getMessage();
      }
    }




    /**
     * Getter method for getting array of logged user data
     * @param int $user_id
     * @return array
     */
    protected function getLoggedUserData(int $user_id): array
    {
      try {
        $sql = "SELECT e.email as email, e.firstname as firstname, e.lastname as lastname, p.position_name as position_name FROM employees e
                        LEFT JOIN position p on e.position_id = p.id
                        WHERE e.id=:user_id AND p.position_name='Administrator' ;";
        $statement = Database::connect()->prepare($sql);
        $statement->bindParam(":user_id", $user_id, \PDO::PARAM_INT);
        $statement->execute();

        if($statement->rowCount() > 0) {
          $results = $statement->fetch();
          return $results;
        } else {
          return ["Triggered Karen at the getLoggedUserEmail class"];
        }

      } catch (\PDOException $e) {
        return [$e->getMessage()];
      }
    }

    /**
     * PDO SELECT query that gets single user by ID
     * @param int $user_id
     * @return array
     */
    protected function getSingleUserByIdData(int $user_id): array
    {
      try {
        $sql = "SELECT p.id as position_id, p.position_name as position_name, e.id as employee_id, e.firstname as firstname, e.lastname as lastname, e.salary as salary, e.email as email
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

    /**
     * PDO Getter method query that returns all users and their position names.
     * @return array
     */
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

    /**
     * PDO getter method that returns filtered users by position
     * @param string $filterPosition
     * @return array
     */
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
     * Get average salary
     * @return array
     */
    protected function getAverageSalaryData(): array
    {
      $result = 0;
      try {
        $sql = "SELECT AVG(salary) as prosecna_plata FROM employees;";
        $statement = Database::connect()->prepare($sql);
        $statement->execute();
        if($statement->rowCount() > 0) {
          $result = $statement->fetch();
        }
      } catch (\PDOException $e) {
        return ["Get Average salary error" => $e->getMessage()];
      }

      return $result;
    }


    /**
     * Get distinct number of employees per position
     * @return array
     */
    protected function getNumberOfEmplyeesPerPositionData(): array
    {
      try {
        $sql = "SELECT p.position_name as position_name, count(DISTINCT e.id) as distinct_position
                FROM employees e
                left join position p on p.id = e.position_id
                GROUP BY position_name;";
        $statement = Database::connect()->prepare($sql);
        $statement->execute();
        if($statement->rowCount() > 0) {
          $results = $statement->fetchAll();
          return $results;
        } else {
          return ["getNumberOfEmplyeesPerPositionData ERROR!"];
        }
      } catch (\PDOException $e) {
        return ["Pdo Error" => $e->getMessage()];
      }

    }


    /**
     * Get number of employees
     * @return string|int
     */
    protected function getTotalNumberOfEmployeesData(): string| int
    {
      try {
        $sql = "SELECT count(DISTINCT id) as number_of_employees FROM employees;";
        $statement = Database::connect()->prepare($sql);
        $statement->execute();
        if($statement->rowCount() > 0) return $statement->fetch()['number_of_employees'];
      } catch (\PDOException $e) {
        return "getTotalNumberOfEmployees Error: ". $e->getMessage();
      }
      return "ok";
    }





    /**
     * Validates email and checks if it exists in the database
     * @param string $email
     * @return bool
     */
    protected function checkUserDataEmailExists(string $email): bool
    {
      $sql = "SELECT email FROM employees WHERE email= :email";
      $statement = Database::connect()->prepare($sql);
      $statement->bindParam(":email", $email, \PDO::PARAM_STR);

      $statement->execute();

      if($statement->rowCount() > 0) {
        return true;
      } else {
        return false;
      }
    }

    /**
     * PDO getter method that checks if password is valid and returns true/false
     * @param string $email
     * @param string $password
     * @return bool
     */
    protected function checkUserValidPassword(string $email,string $password): bool
    {
//      $password = md5($password);
      $sql = "SELECT email FROM employees WHERE email= :email AND password=:password";
      $statement = Database::connect()->prepare($sql);
      $statement->bindParam(":email", $email, \PDO::PARAM_STR);
      $statement->bindParam(":password", $password, \PDO::PARAM_STR);

      $statement->execute();

      if($statement->rowCount() > 0) {
        return true;
      } else {
        return false;
      }
    }







  }