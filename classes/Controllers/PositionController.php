<?php

  namespace Controllers;

  use Models\Position;

  class PositionController extends Position
  {

    public function getAllPositions(): array
    {
      return $this->getAllPositionsData();
    }
  }