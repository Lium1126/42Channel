<?php

    $tempfile = $_FILES['upimg']['tmp_name'];
    $filename = 'upload/' . $_FILES['upimg']['name'];
     
    if (is_uploaded_file($tempfile)) {
        if ( move_uploaded_file($tempfile , $filename )) {
            echo $filename . "をアップロードしました。<br>";
            echo "ファイルタイプ:" . $_FILES['upimg']['type'] . "<br>";
        } else {
            echo "ファイルをアップロードできません。";
        }
    } else {
        echo "ファイルが選択されていません。";
    } 

    echo '<a href="fileup.html">戻る</a>';
?>
