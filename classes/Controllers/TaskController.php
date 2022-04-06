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

    public function __construct()
    {
      date_default_timezone_set('Europe/Belgrade');
      $this->allTasks = $this->getAllTasksData();
      $this->currentTime = strtotime(date("Y-m-d", time()));
    }

    public function getCurrentTimestamp()
    {
      return $this->currentTime;
    }

    public function getAllTasks(): array
    {
      return $this->allTasks;
    }

    public function setDayDifference(int $taskDate) {
      $timestampDiff = $taskDate - $this->getCurrentTimestamp();
      $this->dayDiff = $timestampDiff / 86400;
    }

    public function getDayDifference()
    {
      return $this->dayDiff;
    }

    public function setFieldColor()
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

    public function getFieldColor()
    {
      return $this->fieldColorClass;
    }




    /**
     * Create task method
     * @param int $projectId
     * @param int $userId
     * @param string $taskDescription
     * @param string $taskDeadline
     */
    public static function createTask(int $projectId, int $userId, string $taskDescription, string $taskDeadline)
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