<?php

  namespace Controllers;

  use Models\Task;
  use Models\Project;

  class TaskController extends Task
  {

    private int $currentTime;
    private array $allTasks = [];
    private int $dayDiff;
    private string $fieldColorClass;
    private string $taskDeadline;

    /**
     * Constructing Task class with timezone, alltasks and current time
     */
    public function __construct()
    {
      date_default_timezone_set('Europe/Belgrade');
      $this->allTasks = $this->getAllTasksData();
      $this->currentTime = strtotime(date("Y-m-d", time()));
    }

    /**
     * Getter for the current time
     * @return int
     */
    public function getCurrentTimestamp(): int
    {
      return $this->currentTime;
    }

    /**
     * Getter method that gets all tasks
     * @return array
     */
    public function getAllTasks(): array
    {
      return $this->allTasks;
    }

    public function setDayDifference(int $taskDate) {
      $timestampDiff = $taskDate - $this->getCurrentTimestamp();
      $this->dayDiff = $timestampDiff / 86400;
    }

    /**
     * Getter for day difference
     * @return int
     */
    public function getDayDifference(): int
    {
      return $this->dayDiff;
    }

    /**
     * Setter method for field color
     * @return void
     */
    public function setFieldColor(): void
    {
      if($this->getDayDifference() > 4 && $this->getDayDifference() <= 10) {
        $this->fieldColorClass = "task-good";
      }

      if($this->getDayDifference() > 2 && $this->getDayDifference() <= 4) {
        $this->fieldColorClass = "task-warning";
      }

      if($this->getDayDifference() <= 2) {
        $this->fieldColorClass = "task-alert";
      }
    }

    /**
     * Getter for color class
     * @return string
     */
    public function getFieldColor(): string
    {
      return $this->fieldColorClass;
    }

    /**
     * Create task method
     * @param int $projectId
     * @param int $userId
     * @param string $taskDescription
     * @param string $taskDeadline
     * @return void
     */
    public static function createTask(int $projectId, int $userId, string $taskDescription, string $taskDeadline): void
    {
      $result = (new parent)->createTaskData($projectId, $userId, $taskDescription, $taskDeadline);
      var_dump($result);
      if($result) {
        header("Location: ../dashboard/all-tasks.php");
      } else {
        header("Location: ../dashboard/create-task.php?error=BadDatabaseError");
      }
    }




  }