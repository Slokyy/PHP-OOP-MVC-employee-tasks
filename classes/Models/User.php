<?php

  namespace Models;

  use Database\Database;
  if(!isset($_SESSION))
  {
    session_start();
  }

  class User
  {
    public function getAllUsers(): array
    {
      $sql = "SELECT * FROM employees";
      $db = Database::connect();
      $statement = $db->prepare($sql);

      $statement->execute();
      $results = $statement->fetchAll();
      return $results;
    }

    public function login($email, $password) {
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
          $this->createSession($user_id, $user_role);

          header("Location: ../dashboard/dashboard.php");
//          $test = $user_role;
          return true;
        } else {
//          header("Location: ../index.php");
          return false;
        }

      } catch (\PDOException $e) {
        return $e->getMessage();
      }
    }


    public function createSession($user_id, $user_role)
    {
      $_SESSION['user_id'] = $user_id;
      $_SESSION['role'] = $user_role;
    }

    public function getLoggedUserEmail($user_id): string
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


  }