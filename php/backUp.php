<?php
    try{
        $pdo=new PDO('mysql:host=localhost;dbname=BBS;charset=utf8',
                'staff','password');
    }catch(Exception $e){
        /*接続に失敗*/
        die();
    }
    date_default_timezone_set('Asia/Tokyo');
    date();
    $sqlCount = 'SELECT COUNT(*) FROM ThreadInfo';
    $threadTitleNum = ($pdo->query($sqlCount))->fetchColumn();

      //test
      // $sqlRename = 'ALTER TABLE Thread1 RENAME TO Thread1_buckUp;';
      // $rename = $pdo->query($sqlRename);

    for ($i=1; $i <=$threadTitleNum ; $i++) {
      $sqlThreadRename = 'ALTER TABLE Thread' . $i . ' RENAME TO Thread' . $i .'_'.date(Y).'_'.date(m).'_'.date(d).'_'.date(H).'_'.date(i).'_'.date(s).'_buckUp;';
      // echo $sqlThreadRename;
      $threadRename = $pdo->query($sqlThreadRename);
    }
    $sqlInfoRename = 'ALTER TABLE ThreadInfo RENAME TO ThreadInfo'.'_'.date(Y).'_'.date(m).'_'.date(d).'_'.date(H).'_'.date(i).'_'.date(s).'_buckUp;';
    $InfoRename = $pdo->query($sqlInfoRename);
    $sqlInfoCopy = 'CREATE TABLE ThreadInfo LIKE ThreadInfo'.'_'.date(Y).'_'.date(m).'_'.date(d).'_'.date(H).'_'.date(i).'_'.date(s).'_buckUp;';
    $InfoCopy = $pdo->query($sqlInfoCopy);
    exit;
?>
