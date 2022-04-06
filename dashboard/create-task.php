<?php
  use \Controllers\ProjectController;
  if(!isset($_SESSION)) {
    session_start();
  }


  if (!isset($_SESSION['user_id']) && $_SESSION['role'] !== "Administrator") {
    header("Location: ../index.php");
  }

  if(isset($_SESSION['user_id']) && $_SESSION['role'] === "Administrator") {
    $title = "Add Task";

    include_once("../includes/partials/header.php");
    include_once("../includes/partials/navigation.php");

    $projects = new ProjectController();

    $projectsArr = $projects->getProjectsArr();

    $usersArr = \Controllers\UserController::getAllUsers();

    ?>
    <!--  create-project-view    -->
    <section class="login-section">
      <div class="container flex">
        <h1>Add New Task</h1>
        <form action="../includes/controller.php" method="POST" class="form">

          <div class="form-control">
            <label for="projectSelectName">
              <span>Project:</span>
              <select name="projectId" id="projectSelectName">
                <?php foreach($projectsArr as $project): ?>
                  <option value="<?= $project['id'] ?>"><?= $project['project_name']; ?></option>
                <?php endforeach; ?>
              </select>
            </label>
          </div>

          <div class="form-control">
            <label for="userSelectName">
              <span>Employee:</span>
              <select name="userId" id="userSelectName">
                <?php foreach($usersArr as $user): ?>
                  <option value="<?= $user['employee_id'] ?>">
                    <?=
                      $user['firstname'] ." ".
                      $user['lastname'] .
                      " ( " . $user['position_name'] . " )";
                    ?>
                  </option>
                <?php endforeach; ?>
              </select>
            </label>
          </div>

          <div class="form-control">
            <label for="task-description">
              <span>Task Description:</span>
              <textarea name="taskDescription" class="input-textarea" id="task-description"></textarea>
            </label>
          </div>

          <div class="form-control">
            <label for="task-deadline">
              <span>Task Deadline:</span>
              <input type="date" name="taskDeadline" class="input-date" id="task-deadline">
            </label>
          </div>


          <button type="submit" class="btn btn-submit"  name="createTask">Add Task</button>
        </form>

      </div>
    </section>

    <?php
    include_once("../includes/partials/footer.php");
  } else {
    header("Location: ../index.php");
  }