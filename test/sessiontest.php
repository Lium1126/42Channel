<?php
    session_save_path("/Applications/MAMP/tmp/php/"); 

    // ログインした状態と同等にする
    session_start();
    // session_regenerate_id();

    // ランダムバイナリから16進数に変換してワンタイムトークンとする
    $token_byte = openssl_random_pseudo_bytes(16);
    $csrf_token = bin2hex($token_byte);

    $_SESSION['csrf_token'] = $csrf_token;

    echo "セッションID:" . session_id() . "<br>";
    echo "トークンストリング:" . $csrf_token . "<br>";
    echo "ワンタイムトークン:" . $_SESSION['csrf_token'];
?>

<html>
    <body>
        <form method="POST" action="csrftest.php">
            <input type="hidden" name="csrf_token" value="<?=$csrf_token?>">
            <input type="text" name="sendtext">
            <input type="submit" value="送信">
        </form>
    </body>
</html>
