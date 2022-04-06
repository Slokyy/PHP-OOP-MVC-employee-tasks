<?php

  namespace Models;

  use Database\Database;

  class Task
  {


    /**
     * Method that enters data into tasks table
     * @param int $projectId
     * @param int $userId
     * @param string $taskDescription
     * @param string $taskDeadline
     * @return bool
     */
    protected function createTaskData(int $projectId, int $userId, string $taskDescription, string $taskDeadline): bool
    {
      try {
        $sql = "INSERT INTO tasks (project_id, employee_id, task_description, task_deadline) VALUES(:projectId, :userId, :taskDescription, :taskDeadline);";

        $statement = Database::connect()->prepare($sql);
        $statement->bindParam(":projectId", $projectId, \PDO::PARAM_INT);
        $statement->bindParam(":userId", $userId, \PDO::PARAM_INT);
        $statement->bindParam(":taskDescription", $taskDescription, \PDO::PARAM_STR);
        $statement->bindParam(":taskDeadline", $taskDeadline, \PDO::PARAM_STR);

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


    protected function getAllTasksData(): array
    {
      try {
        $sql = "SELECT t.task_description AS task_description, t.task_deadline AS task_deadline, p.project_name AS project_name, e.firstname AS firstname, e.lastname AS lastname, po.position_name AS position_name
                    FROM tasks t
                        LEFT JOIN projects p on t.project_id = p.id
                        LEFT JOIN employees e on t.employee_id = e.id
                        LEFT JOIN position po on e.position_id = po.id
                        ORDER BY p.project_name, po.position_name, e.firstname DESC;";
        $statement = Database::connect()->prepare($sql);

        $statement->execute();
        if($statement->rowCount() > 0) {
          return $statement->fetchAll();
        } else {
          return ["Data error" => "No data found"];
        }
      } catch (\PDOException $e) {
        return ["PdoError" =>$e->getMessage()];
      }
    }


  }