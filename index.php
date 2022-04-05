<?php


  // Page
  $title = "Login";
  include_once("./includes/partials/header.php");

  include_once("./autoloader.php");
//  $loginController = new \Controllers\LoginController();
  if(!isset($_SESSION['login_errors'])) {
    session_start();
  }

  $errorMessages = [];
  if(isset($_SESSION['login_errors'])) {
    $errorMessages = $_SESSION['login_errors'];
  }


  $_SESSION = array();
  if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
      $params["path"], $params["domain"],
      $params["secure"], $params["httponly"]
    );
  }



  if(isset($_SESSION['login_errors'])) {
    session_destroy();
  }




?>


  <section class="login-section">
    <div class="container flex">
      <h1>Login</h1>

      <form action="./includes/controller.php" method="POST" class="form flex">
        <span><?= $errorMessages['emailPasswordErr'] ?? ""; ?></span>
        <div class="form-control">
          <label for="email">
            <span>Enter email:</span>
            <input type="text" name="email" id="email">
            <span class="input-error"><?= $errorMessages['emailNotFoundError'] ?? ""; ?></span>
            <span class="input-error"><?= $errorMessages['invalidEmail'] ?? ""; ?></span>

            <span class="input-error"><?= $errorMessages['emptyEmailError'] ?? ""; ?></span>

          </label>
        </div>
        <div class="form-control">
          <label for="password">
            <span>Enter password:</span>
            <input type="password" name="password" id="password">
            <span class="input-error"><?= $errorMessages['passwordError'] ?? ""; ?></span>
            <span class="input-error"><?= $errorMessages['emptyPasswordError'] ?? ""; ?></span>

          </label>
        </div>
        <button type="submit" class="btn btn-submit" name="login">Posalji</button>
      </form>
    </div>
  </section>

  <?php
    require_once("./includes/partials/footer.php");
  ?>
