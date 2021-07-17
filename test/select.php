<?php

  $link = mysqli_connect('localhost', 'user', 'pass', 'testdb');

  // 接続状況をチェックします
  if (mysqli_connect_errno()) {
    die("データベースに接続できません:" . mysqli_connect_error() . "\n");
  }

  echo "データベースの接続に成功しました。<br>";

  // userテーブルの全てのデータを取得する
  // $queryにはSQL文が入っている
  $query = "SELECT * FROM testtable;";

  // クエリを実行します。
  if ($result = mysqli_query($link, $query)) {
    echo "SELECT に成功しました。<br>";
    foreach ($result as $row) {
      var_dump($row);
      echo "<br>";
    }
  }

  // 接続を閉じます
  mysqli_close($link);
 ?>
