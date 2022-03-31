<?php
//  require_once("./includes/controller.php");


  // Page
  $title = "Login";
  include_once("./includes/partials/header.php");
  session_start();
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
        <div class="form-control">
          <label for="email">
            <span>Enter email:</span>
            <input type="email" name="email" id="email">
          </label>
        </div>
        <div class="form-control">
          <label for="password">
            <span>Enter password:</span>
            <input type="password" name="password" id="password">
          </label>
        </div>
        <button type="submit" class="btn btn-submit" name="login">Posalji</button>
      </form>
    </div>
  </section>

  <?php
    echo __DIR__;
    require_once("./includes/partials/footer.php");
  ?>
