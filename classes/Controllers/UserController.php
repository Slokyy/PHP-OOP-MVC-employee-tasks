<?php

  namespace Controllers;

  use Models\User;

  class UserController extends User
  {


    public function getUserEmail($user_id): string
    {
      return $this->getLoggedUserEmail($user_id);
    }

    public function getUsersByFilteredData($filter): array {
      if($filter === "all") {
        return $this->getAllUsersData();
      } else {
        return $this->getUsersByPositionNameData($filter);
      }
    }

    public function getSingleUserById($user_id): array
    {
      return $this->getSingleUserByIdData($user_id);
    }


  }