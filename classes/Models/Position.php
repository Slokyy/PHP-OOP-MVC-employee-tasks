<?php

  namespace Models;

  use Database\Database;


  class Position
  {
    public array $positions = [];

    /**
     * Get all positions
     * @return array
     */
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

    /**
     * Get position name using id
     * @param int $positionId
     * @return string
     */
    protected function getPositionNameByIdData(int $positionId): string
    {
      $sql = "SELECT position_name FROM position
                    WHERE id=:position_id;";
      $statement = Database::connect()->prepare($sql);
      $statement->bindParam(":position_id", $positionId);
      $statement->execute();
      if($statement->rowCount() > 0) {
        $result = $statement->fetch();
        return $result['position_name'];
      } else {
        return "Some getPositionNameById Error";
      }
    }

  }