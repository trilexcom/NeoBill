<?php
  $folder = 'templates';
  if (strrpos($_SERVER['PHP_SELF'], '/' . $folder . '/index.php') === (strlen($_SERVER['PHP_SELF']) - strlen('/' . $folder . '/index.php'))) {
    header('Location: http://' . $_SERVER['HTTP_HOST'] . '/' . substr($_SERVER['PHP_SELF'], 1, strrpos($_SERVER['PHP_SELF'], '/' . $folder . '/index.php')));
  } else {
    header('Location: http://' . $_SERVER['HTTP_HOST'] . '/');
  }
?>