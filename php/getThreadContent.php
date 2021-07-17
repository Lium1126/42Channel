<?php
    try{
        $pdo = new PDO('mysql:host=localhost;dbname=BBS;charset=utf8',
                    'staff','password');
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

    $count=0;

    for($i=0;$i<$_GET['end']-$_GET['begin']+1;$i++){
        $count++;
    }

    $arraySuccess=[
        'state' => 'SUCCESS',
        'resp_num' => $count
    ];

    $count=0;
    $sqlThreadInfo='SELECT * FROM Thread'.$_GET['threadID'];
    $result=$pdo->query($sqlThreadInfo);
    foreach($result as $res){
        $sub[$count]=[
            'ID' => $res['ID'],
            'content' => mb_convert_encoding(htmlspecialchars($res['Content']),"UTF-8","auto"),
            'date' =>[
                'year' => $res['year'],
                'month' => $res['month'],
                'day' => $res['day'],
                'hour' => $res['hour'],
                'minute' => $res['minute'],
                'second' => $res['sec']
            ],
            'img' => $res['img'],
        ];
        $count++;
    }

    $count=$_GET['begin']-1;

    for($i=0;$i<($_GET['end']-$_GET['begin'])+1;$i++){
        if($i==0){
            $arraySuccess['resp_data'][0]=$sub[$count];
        }else{
            array_push($arraySuccess['resp_data'],$sub[$count]);
        }
        $count++;
    }

    header("Content-Type: application/json; charset=utf-8");

    echo json_encode($arraySuccess);
?>
