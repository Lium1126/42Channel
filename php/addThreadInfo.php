<?php
    try{
        $pdo=new PDO('mysql:host=[ホスト];dbname=[DB名];charset=utf8',
                '[ユーザー名]','[パスワード]');
    }catch(Exception $e){
        /*接続に失敗*/
        die();
    }

    /*接続に成功*/

    $sqlThreadInfoNum='SELECT COUNT(*) FROM ThreadInfo';
    $threadInfoNum=($pdo->query($sqlThreadInfoNum))->fetchColumn();
    $threadInfoNum++;

    /*ThreadInfoに追加*/
    $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

    $sqlAddThreadInfo="INSERT INTO ThreadInfo (ID,threadTitle) VALUES(?, ?);";

    $stmt=$pdo->prepare($sqlAddThreadInfo);
    $stmt->setFetchMode(PDO::FETCH_ASSOC);

    $stmt->bindParam(1, $threadInfoNum ,PDO::PARAM_INT);
    $stmt->bindParam(2, $_GET['title'],PDO::PARAM_STR);

    $stmt->execute();

    /*Thread??テーブルを作成*/
    $sqlCreateTable='CREATE TABLE Thread'.$threadInfoNum.'(
        ID INT(11) AUTO_INCREMENT PRIMARY KEY,
        Content text,
        year INT(11),
        month INT(11),
        day INT(11),
        hour INT(11),
        minute INT(11),
        sec INT(11),
        img VARCHAR(256)
    )engine=innodb default charset=utf8';

    $pdo->query($sqlCreateTable);

    $title=urlencode($_GET['title']);

    $url='../html/view.html?threadID='.$threadInfoNum.'&num=0&title='.$title;

    header('Location: '.$url);
    exit;

?>