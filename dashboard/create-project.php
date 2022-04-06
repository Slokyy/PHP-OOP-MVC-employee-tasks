<?php

  if(!isset($_SESSION)) {
    session_start();
  }


  if (!isset($_SESSION['user_id']) && $_SESSION['role'] !== "Administrator") {
    header("Location: ../index.php");
  }

  if(isset($_SESSION['user_id']) && $_SESSION['role'] === "Administrator") {
    $title = "Add Project";

    include_once("../includes/partials/header.php");
    include_once("../includes/partials/navigation.php");
    ?>
<!--  create-project-view    -->
    <section class="login-section">
      <div class="container flex">
        <h1>Add New Project</h1>
        <form action="../includes/controller.php" method="POST" class="form">
          <div class="form-control">
            <label for="project-name">
              <span>Project Name:</span>
              <input type="text" name="projectName" id="project-name">
            </label>
          </div>
          <div class="form-control">
            <label for="project-escription">
              <span>Project Description:</span>
              <textarea name="projectDescription" class="input-textarea" id="project-description"></textarea>
            </label>
          </div>
          <button type="submit" class="btn btn-submit"  name="createProject">Add new Project</button>
        </form>
      </div>
    </section>
    <?php
    include_once("../includes/partials/footer.php");
  } else {
    header("Location: ../index.php");
  }