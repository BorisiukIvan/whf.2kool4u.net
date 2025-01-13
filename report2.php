<?php
  include 'backend/logger.php';
  if ($_SERVER['REQUEST_METHOD'] == "GET") {
      http_response_code('302');
      header("Location: /report.php");
  } else {
      file_put_contents('backend/reports', "====\nDATA: ". $account .", " . $_SERVER['REMOTE_ADDR'] . ', ' . $_SERVER['HTTP_USER_AGENT'] . ', ' . date('l jS \of F Y h:i:s A') . ";\nTO: " . $_POST['who2'] . "\nWHAT: " . $_POST['body'] . "\n", FILE_APPEND);
      http_response_code('303');
      header("Location: /report.php?ok=1");
  }
?>
