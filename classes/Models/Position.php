<?php

  namespace Models;

  use Database\Database;


  class Position
  {
    public array $positions = [];
    public string $activeFilterPosition = "all";

    public function getAllPositionsData(): array
    {

      $sql = "SELECT id,position_name FROM position;";
      $statement = Database::connect()->prepare($sql);

      $statement->execute();
      while ($row = $statement->fetchAll()) {
        foreach ($row as $result) {
          $this->positions[] = [
            "position_id" => $result['id'],
            "position_name" => $result['position_name']];
        }
      }
      return $this->positions;
    }

    public function getPositionNameById(int $positionId)
    {
      $sql = "SELECT position_name FROM position
                    WHERE id=:position_id;";
      $statement = Database::connect()->prepare($sql);
      $statement->bindParam(":position_id", $positionId);
      $statement->execute();
      if($statement->rowCount() > 0) {
        $result = $statement->fetch();
        return $result['position_name'];
        // $this->setActiveFilterPosition($result['position_name']);
      } else {
        return "Some getPositionNameById Error";
      }
    }

    public function setActiveFilterPosition(string $positionName)
    {
      $this->activeFilterPosition = $positionName;
    }

    public function getActiveFilterPosition(): string
    {
      return $this->activeFilterPosition;
    }
  }