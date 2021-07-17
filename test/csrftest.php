<?php
    session_save_path("/Applications/MAMP/tmp/php/"); 
    session_start();

    echo 'POST   :' . $_POST['csrf_token'] . '<br>';
    echo 'SESSION:' . $_SESSION['csrf_token'] . '<br>';

    if (isset($_POST['csrf_token']) && $_SESSION['csrf_token'] === $_POST['csrf_token']) {
        echo '正常なリクエストです<br>';
    } else {
        echo '不正なリクエストです<br>';
    }
    echo $_POST['sendtext'] . '<br>';
    echo '<a href="sessiontest.php">戻る</a>';
?>
