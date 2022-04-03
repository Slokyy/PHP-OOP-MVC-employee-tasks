<?php

  namespace Controllers;

  use Controllers\UserController;
  use Models\User;
  use Models\Position;

  class DashboardController
  {
    private int $totalNumberOfEmployees;
    private float $averageSalary;
    private array $distinctEmployeePositions;
    private \Controllers\UserController $userController;

    public function __construct()
    {
      $this->userController = new UserController();
      $this->totalNumberOfEmployees = $this->userController->getNumberOfEmployees();
      $this->averageSalary = $this->userController->getAverageSalary()['prosecna_plata'];
      $this->distinctEmployeePositions = $this->userController->getGroupedEmployeeData();
    }

    public function getTotalNumberOfEmployees()
    {
      return $this->totalNumberOfEmployees;
    }

    public function getAvgSalary(): float
    {
      $this->averageSalary = number_format($this->averageSalary, 2, ".", "");
      return $this->averageSalary;
    }

    public function getGroupedEmployees() {
      return $this->distinctEmployeePositions;
    }

  }