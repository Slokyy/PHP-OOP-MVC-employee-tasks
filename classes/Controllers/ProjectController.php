<?php

  namespace Controllers;

  use Models\Project;

  class ProjectController extends Project
  {

    private array $projectsArr = [];

    /**
     * Setter for project class with array
     */
    public function __construct()
    {
      $this->projectsArr = $this->getAllProjectData();
    }

    /**
     * @return array
     */
    public function getProjectsArr(): array
    {
      return $this->projectsArr;
    }

    /**
     * @param array $projectsArr
     */
    public function setProjectsArr(array $projectsArr): void
    {
      $this->projectsArr = $projectsArr;
    }


    /**
     * Create new project
     * @param string $projectName
     * @param string $projectDescription
     * @return bool
     */
    public static function createNewProject(string $projectName, string $projectDescription): bool
    {
      if(strlen($projectName) == 0) {
        header("Location: ../dashboard/create-project.php?errorNameEmpty=falseNameIsTrue");
        return true;
      }

      if(strlen($projectDescription) == 0) {
        header("Location: ../dashboard/create-project.php?errorDescriptionEmpty=falseDescriptionIsTrue");
        return true;
      }

      $result = (new parent)->createNewProjectData($projectName, $projectDescription);
      header("Location: ../dashboard/create-project.php?successfullEntry=$result");

      return true;
    }

  }