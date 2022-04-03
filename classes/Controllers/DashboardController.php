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

    /**
     * Getter method that gets number of employees from UserController (User Model)
     * @return int
     */
    public function getTotalNumberOfEmployees(): int
    {
      return $this->totalNumberOfEmployees;
    }

    /**
     * Getter method that gets average salary of employees from UserController (User Model)
     * @return float
     */
    public function getAvgSalary(): float
    {
      $this->averageSalary = number_format($this->averageSalary, 2, ".", "");
      return $this->averageSalary;
    }

    /**
     * Getter method that gets counted number of employees per position from UserController (User Model)
     * @return array
     */
    public function getGroupedEmployees(): array
    {
      return $this->distinctEmployeePositions;
    }

  }