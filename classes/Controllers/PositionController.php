<?php

  namespace Controllers;

  use Models\Position;

  class PositionController extends Position
  {

    /**
     * Simple getter for all positions in position table
     * @return array
     */
    public function getAllPositions(): array
    {
      return $this->getAllPositionsData();
    }

    /**
     * Getting position name by id, helper function calls Position model method
     * @param int $positionId
     * @return string
     */
    public function getPositionNameById(int $positionId)
    {
      return $this->getPositionNameByIdData($positionId);
    }
  }