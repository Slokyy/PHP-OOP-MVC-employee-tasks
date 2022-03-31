<?php

  namespace Controllers;

  use Models\User;

  class LoginController extends User
  {
    public function getLoggedUser($email, $password)
    {
      return $this->login($email, $password);
    }

  }