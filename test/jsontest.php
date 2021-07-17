<?php
  $data = ['state' => 'SUCCESS', 'result' => 'OK', 'query' => $_GET['query']];
  header("Content-Type: application/json; charset=utf-8");
  echo json_encode($data);
?>
