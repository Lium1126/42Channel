<?php

    header('Content-Type: text/plain; charset=utf-8');

    // POSTリクエストによるページ遷移かチェック
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        try {

            // 未定義である・複数ファイルである・$_FILES Corruption 攻撃を受けた
            // どれかに該当していれば不正なパラメータとして処理する
            if (!isset($_FILES['upimg']['error']) || !is_int($_FILES['upimg']['error'])) {
                throw new RuntimeException('パラメータが不正です');
            }
        
            // $_FILES['upimg']['error'] の値を確認
            switch ($_FILES['upimg']['error']) {
                case UPLOAD_ERR_OK: // OK
                    break;
                case UPLOAD_ERR_NO_FILE:   // ファイル未選択
                    throw new RuntimeException('ファイルが選択されていません');
                case UPLOAD_ERR_INI_SIZE:  // php.ini定義の最大サイズ超過
                case UPLOAD_ERR_FORM_SIZE: // フォーム定義の最大サイズ超過 (設定した場合のみ)
                    throw new RuntimeException('ファイルサイズが大きすぎます');
                default:
                    throw new RuntimeException('その他のエラーが発生しました');
            }

            // ファイルが空の場合
            if ($_FILES['upimg']['size'] == 0) {
                throw new RuntimeException('ファイルが空です');
            }
        
            // $_FILES['upimg']['mime']の値はブラウザ側で偽装可能なので
            // MIMEタイプに対応する拡張子を自前で取得する
            if (!$ext = array_search(
                mime_content_type($_FILES['upimg']['tmp_name']),
                array(
                    'gif' => 'image/gif',
                    'jpg' => 'image/jpeg',
                    'png' => 'image/png',
                ),
                true
            )) {
                throw new RuntimeException('ファイル形式が不正です');
            }
            
            // 画像ファイルの有無を確認
            if (is_uploaded_file($_FILES['upimg']['tmp_name'])) {
                // ファイルデータからSHA-1ハッシュを取ってファイル名を決定し，保存する
                $upload_path = './upload/';
                $file_name = date('YmdHis') . '_' . sprintf('%s.%s', sha1_file($_FILES['upimg']['tmp_name']), $ext);

                if (!move_uploaded_file($_FILES['upimg']['tmp_name'], $upload_path . $file_name)) {
                    throw new RuntimeException('ファイル保存時にエラーが発生しました');
                }
            } else {
                throw new RuntimeException('画像ファイルがありません');
            }
        
            // ファイルのパーミッションを確実に0644に設定する
            chmod($path, 0644);
        
            echo 'ファイルは正常にアップロードされました';

        } catch (RuntimeException $e) {
        
            echo $e->getMessage();
        
        }

    // POSTリクエストによる遷移じゃない場合
    } else {
        echo '不正なアクセスです';
    }
?>
