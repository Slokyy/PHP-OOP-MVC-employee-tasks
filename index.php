<?php
//  require_once("./includes/controller.php");


  // Page
  $title = "Login";
  include_once("./includes/partials/header.php");

  include_once("./autoloader.php");
  $loginController = new \Controllers\LoginController();
//  var_dump($loginController->getErrorData());
//  session_start();
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



  session_destroy();



?>


  <section class="login-section">
    <div class="container flex">
      <h1>Login</h1>

      <form action="./includes/controller.php" method="POST" class="form flex">
        <span><?= $errorMessages['emailPasswordErr'] ?? ""; ?></span>
        <div class="form-control">
          <label for="email">
            <span>Enter email:</span>
            <input type="email" name="email" id="email">
            <span><?= $errorMessages['emailNotFoundError'] ?? ""; ?></span>
            <span><?= $errorMessages['emptyEmailError'] ?? ""; ?></span>

          </label>
        </div>
        <div class="form-control">
          <label for="password">
            <span>Enter password:</span>
            <input type="password" name="password" id="password">
            <span><?= $errorMessages['passwordError'] ?? ""; ?></span>
            <span><?= $errorMessages['emptyPasswordError'] ?? ""; ?></span>

          </label>
        </div>
        <button type="submit" class="btn btn-submit" name="login">Posalji</button>
      </form>
    </div>
  </section>

  <?php
    require_once("./includes/partials/footer.php");
  ?>
