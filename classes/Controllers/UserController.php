<?php

  namespace Controllers;

  use Models\User;

  class UserController extends User
  {


    public function getUserEmail($user_id): string
    {
      return $this->getLoggedUserEmail($user_id);
    }
  }