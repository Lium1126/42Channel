<?php
  /*
  $data = ['state' => 'SUCCESS', 'result' => 'OK', 'query' => $_GET['query']];
  header("Content-Type: application/json; charset=utf-8");
  echo json_encode($data);
  */
  $data = ['state' => 'SUCCESS', 'num' => 0, 'begin' => $_GET['begin'], 'end' => $_GET['end'], 'threadID' => $_GET['threadID']];
  $sub = ['ID' => 1, 'content' => '掲示板作ってみた'];
  $date = ['year' => 2020, 'month' => 6, 'day' => 3, 'hour' => 17, 'minute' => 37, 'second' => 25];
  $sub['date'] = $date;
  $data['resp_data'][0] = $sub;
  $data['num']++;
  header("Content-Type: application/json; charset=utf-8");
  echo json_encode($data);
?>
