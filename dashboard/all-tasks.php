<?php

if (!isset($_SESSION)) {
  session_start();
}

if (isset($_SESSION['user_id']) && $_SESSION['role'] === "Administrator") {
  $title = "All Tasks";


  include_once("../includes/partials/header.php");
  include_once("../includes/partials/navigation.php");

  $tasks = new \Controllers\TaskController();
  $tasksArr = $tasks->getAllTasks();



?>
  <div class="container flex flex-center flex-column ">

    <table class="table">
      <thead>
        <tr>
          <th>Project Name</th>
          <th>Task Description</th>
          <th>Role</th>
          <th>Employee</th>
        </tr>
      </thead>
      <tbody>

        <?php foreach ($tasksArr as $task) : ?>
          <?php
          $currentDate = $task['task_deadline'];
          $taskDeadline = strtotime($task['task_deadline']);
          $tasks->setDayDifference($taskDeadline);
          $tasks->setFieldColor();
          $bgColor = $tasks->getFieldColor();
          ?>
          <tr class="text-bold-size <?php echo empty($bgColor) ? "" : $bgColor ?>">

            <td><?= $task['project_name']; ?></td>
            <td><?= $task['task_description']; ?></td>
            <td><?= $task['position_name']; ?></td>
            <td><?= $task['firstname'] . " " . $task['lastname']; ?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
<?php
  include_once("../includes/partials/footer.php");
} else {
  header("Location: ../index.php");
}
