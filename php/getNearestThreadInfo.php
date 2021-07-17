<?php
    try{
        $pdo=new PDO('mysql:host=[ホスト];dbname=[DB名];charset=utf8',
        '[ユーザー名]','[パスワード]');
    }catch(Exception $e){
        /*接続に失敗*/
        $arrayFailure=[
            'state'=>'FAILURE'
        ];
        header("Content-Type: application/json; charset=utf-8");
        echo json_encode($arrayFailure);
        die();
    }

    /*接続に成功*/

    $sqlThreadTitleNum='SELECT COUNT(*) FROM ThreadInfo';
    $threadTitleNum=($pdo->query($sqlThreadTitleNum))->fetchColumn();
    if($threadTitleNum>5) $threadTitleNum=5;
    
    $arraySuccess=[
        'state' => 'SUCCESS',
        'resp_num' => $threadTitleNum
    ];

    $sqlThreadInfo='SELECT * FROM ThreadInfo ORDER BY ID DESC LIMIT '.$threadTitleNum;
    $result=$pdo->query($sqlThreadInfo);
    $count=0;
    foreach($result as $res){
        $sqlThreadWritingNum='SELECT COUNT(*) FROM Thread'.$res['ID'];
        $threadWritingNum=($pdo->query($sqlThreadWritingNum))->fetchColumn();
        $sub[$count]=[
            'ID' => $res['ID'],
            'num' => $threadWritingNum,
            'title' => $res['threadTitle']
        ];
        $count++;
    }

    for($i=0;$i<$threadTitleNum;$i++){
        if($i==0){
            $arraySuccess['resp_data'][0]=$sub[$i];
        }else{
            array_push($arraySuccess['resp_data'],$sub[$i]);
        }
    }

    header("Content-Type: application/json; charset=utf-8");

    echo json_encode($arraySuccess);
?>