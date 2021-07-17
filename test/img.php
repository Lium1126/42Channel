<?php
    $img_name = $_GET['img_name'];

    $img_dir = './upload/' . $img_name;

    $imginfo = getimagesize($img_dir);

    header('Content-Type: ' . $imginfo['mime']);
    readfile($img_dir);
?>