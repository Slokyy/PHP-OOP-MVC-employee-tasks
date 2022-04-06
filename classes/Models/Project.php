<?php

  namespace Models;

  use Database\Database;

  class Project
  {

    /**
     * Insert project data into project table
     * @param string $projectName
     * @param string $projectDescription
     * @return string
     */
    protected function createNewProjectData(string $projectName, string $projectDescription): string
    {
      try {
        $sql = "INSERT INTO projects (project_name, project_description) VALUES (:projectName, :projectDescription)";
        $statement = Database::connect()->prepare($sql);
        $statement->bindParam(":projectName", $projectName, \PDO::PARAM_STR);
        $statement->bindParam(":projectDescription", $projectDescription, \PDO::PARAM_STR);

        $statement->execute();
        if($statement->rowCount() > 0) {
          return "Succesfully created ". $statement->rowCount() . " inserted";
        } else {
          return "Error creating project";
        }
      } catch (\PDOException $e) {
        return $e->getMessage();
      }
    }

    protected function getAllProjectData(): array
    {
      try {
        $sql = "SELECT id, project_name, project_description FROM projects WHERE project_name IS NOT NULL AND project_description IS NOT NULL";
        $statement = Database::connect()->prepare($sql);

        $statement->execute();
        if($statement->rowCount() > 0) {
          $results = $statement->fetchAll();
          return $results;
        } else {
          return ["0 rows found!"];
        }
      } catch (\PDOException $e) {
        return ["PDO Error" => $e->getMessage()];
      }
    }
  }