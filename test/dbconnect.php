<?php

  $link = mysqli_connect('localhost', 'user', 'pass', 'testdb');

  // 接続状況をチェックします
  if (mysqli_connect_errno()) {
      die("データベースに接続できません:" . mysqli_connect_error() . "\n");
    } else {
      echo "データベースの接続に成功しました。\n";
    }

    // 接続を閉じます
    mysqli_close($link);

 ?>
