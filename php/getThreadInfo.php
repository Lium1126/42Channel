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
    // 静的プレースホルダを指定
    $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

    $title=$_GET['query'];
    $title=change($title);

    $sqlSearchThreadTitle="SELECT * FROM ThreadInfo WHERE threadTitle LIKE ? ESCAPE '#';";
    $stmt=$pdo->prepare($sqlSearchThreadTitle);
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $stmt->bindParam(1,$title,PDO::PARAM_STR);
    
    $stmt->execute();

    $count=0;
    while($res=$stmt->fetch()){
        $sqlThreadWritingNum='SELECT COUNT(*) FROM Thread'.$res['ID'];
        $threadWritingNum=($pdo->query($sqlThreadWritingNum))->fetchColumn();
        $sub[$count]=[
            'ID' => $res['ID'],
            'num' => $threadWritingNum,
            'title' => $res['threadTitle']
        ];
        $count++;
    }

    $arraySuccess=[
        'state' => 'SUCCESS',
        'resp_num' => $count
    ];

    for($i=0;$i<$count;$i++){
        if($i==0){   
            $arraySuccess['resp_data'][0]=$sub[$i];
        }else{
            array_push($arraySuccess['resp_data'],$sub[$i]);
        }
    }

    header("Content-Type: application/json; charset=utf-8");

    echo json_encode($arraySuccess);

    function change($str){
        return "%" . mb_ereg_replace('([_%#])', '#\1', $str) . "%";
    }
?>