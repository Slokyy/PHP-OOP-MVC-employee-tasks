
<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>MacroHard <?= isset($title) ? " | $title" : ""; ?></title>
  <?php $cssResetPath = ($title === "Login") ? "./includes/css/reset.css" : "../includes/css/reset.css"; ?>
  <?php $cssPath = ($title === "Login") ? "./includes/css/style.css" : "../includes/css/style.css"; ?>
  <link rel="stylesheet" href=<?= $cssResetPath ?>>
  <link rel="stylesheet" href=<?= $cssPath ?>>
</head>
<body>