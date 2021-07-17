<?php
$path = $_FILES['upimg']['tmp_name'];
$mime = shell_exec('file -bi '.escapeshellcmd($path));
$mime = trim($mime);
$mime = preg_replace("/ [^ ]*/", "", $mime);
print($mime);
?>