<?php

  namespace Controllers;

  use Controllers\UserController;
  use Models\User;
  use Models\Position;

  class DashboardController extends User
  {
    public int $totalNumberOfEmployees;
    public float $averageSalary;
    public array $distinctEmployeePositions;


    public function __construct()
    {
      $this->totalNumberOfEmployees = $this->setNumberOfEmployees();
      $this->averageSalary = $this->setAverageSalary()['prosecna_plata'];
      $this->distinctEmployeePositions = $this->setGroupedEmployeeData();
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


    public function setNumberOfEmployees(): int | string
    {
      return $this->getTotalNumberOfEmployeesData();
    }

    public function setAverageSalary(): array
    {
      return $this->getAverageSalaryData();
    }

    public function setGroupedEmployeeData(): array
    {
      return $this->getNumberOfEmplyeesPerPositionData();
    }
  }