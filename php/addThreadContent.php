<?php
    // セッションスタート
    session_save_path("/Applications/MAMP/tmp/php/"); 
    session_start();

    // CSRF対策
    try {
        if (!isset($_POST['csrf_token']) || $_SESSION['csrf_token'] !== $_POST['csrf_token']) {
            throw new RuntimeException('不正なリクエストです');
        }
    }catch(RuntimeException $e){
        die($e->getMessage());
    }

    // データベースに接続
    try{
        $pdo=new PDO('mysql:host=[ホスト];dbname=[DB名];charset=utf8',
                '[ユーザー名]','[パスワード]');
    }catch(Exception $e){
        /*接続に失敗*/
        die('データベースに接続できませんでした');
    }

    /*接続に成功*/

    // 現在時刻を取得
    date_default_timezone_set('Asia/Tokyo');
    date();

    // ファイルの有無を確認
    if ($_FILES['upimg']['error'] != UPLOAD_ERR_NO_FILE) {  // ファイルがあったら
        if($_SERVER['REQUEST_METHOD']==='POST') {
            try{
                if(!isset($_FILES['upimg']['error']) || is_array($_FILES['upimg']['error'])){
                    throw new RuntimeException('パラメータが不正です');
                }
        
                switch($_FILES['upimg']['error']){
                    case UPLOAD_ERR_OK: break;
                    case UPLOAD_ERR_NO_FILE: throw new RuntimeException('ファイルが未選択です');
                    case UPLOAD_ERR_INI_SIZE:
                    case UPLOAD_ERR_FORM_SIZE: throw new RuntimeException('ファイルサイズが大きすぎます');
                    default: throw new RuntimeException('不明なエラーが発生しました');
                }
        
                if($_FILES['upimg']['size']==0){
                    throw new RuntimeException('ファイルが空です');
                }
        
                $finfo=new finfo(FILEINFO_MIME_TYPE);
                if(false===$ext=array_search($finfo->file($_FILES['upimg']['tmp_name']),
                    array(
                        'jpg'=>'image/jpeg',
                        'png'=>'image/png',
                        'gif'=>'image/gif',
                        'bmp'=>'image/x-ms-bmp',
                        'tif'=>'image/tiff'
                    ),
                    true
                )){
                    throw new RuntimeException('ファイル形式が不正です。');
                }
        
                if(count(token_get_all($image))>=2){
                    throw new RuntimeException('そのファイルは受付け出来ません');
                }
        
                if(is_uploaded_file($_FILES['upimg']['tmp_name'])){
                    $upload_path='../upload/';
                    $file_name=date('YmdHis').'_'.sprintf('%s_%s.%s',sha1_file($_FILES['upimg']['tmp_name']), session_id(), $ext);
                    if(!move_uploaded_file($_FILES['upimg']['tmp_name'],$upload_path . $file_name)){
                        throw new RuntimeException('ファイル保存時にエラーが発生しました');
                    }
                }else{
                    throw new RuntimeException('画像ファイルがありません');
                }
        
                chmod($path,0644);

            }catch(RuntimeException $e){
                die($e->getMessage());
            }
        }else{
            die('不正なアクセスです');
        }
    } else {
        $file_name = null;
    }

    /*現在あるスレッドの数を取得*/
    $threadTitleNum = ($pdo->query("SELECT COUNT(*) FROM ThreadInfo;"))->fetchColumn();
    $threadID = intval($_POST['threadID']);

    if(!(0 < $threadID && $threadID <= $threadTitleNum)){
        die();
    }

    $sqlThreadWritingNum='SELECT COUNT(*) FROM Thread'.$_POST['threadID'];
    $threadWritingNum=($pdo->query($sqlThreadWritingNum))->fetchColumn();
    $threadWritingNum++;
    
    $sqlAddThreadWriting="INSERT INTO Thread".$_POST['threadID']." (ID,Content,year,month,day,hour,minute,sec,img)"
                        ." VALUES(?,?,"
                        .date(Y).','.date(m).','.date(d).','.date(H).','.date(i).','.date(s).',?);';

    $stmt=$pdo->prepare($sqlAddThreadWriting);
    $stmt->setFetchMode(PDO::FETCH_ASSOC);

    $stmt->bindParam(1,$threadWritingNum,PDO::PARAM_INT);
    $stmt->bindParam(2,$_POST['content'],PDO::PARAM_STR);

    if ($_FILES['upimg']['error'] != UPLOAD_ERR_NO_FILE) {  // ファイルがあったら
        $file_name = "upload/".$file_name;
        $stmt->bindParam(3,$file_name,PDO::PARAM_STR);
    } else {
        $stmt->bindValue(3,null,PDO::PARAM_NULL);
    }

    $stmt->execute();

    $sqlGetTitle='SELECT * FROM ThreadInfo WHERE ID='.$_POST['threadID'];
    $result = $pdo->query($sqlGetTitle);
    $title = "";
    foreach($result as $temp) {
        $title = $temp['threadTitle'];
    }
    
    $url='../html/view.html?threadID='.$_POST['threadID'].'&num='.$threadWritingNum.'&title='.urlencode($title)."#content".$threadWritingNum;

    header('Location: '.$url);
    exit;
    
?>
