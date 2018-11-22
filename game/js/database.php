<?php

$db = new mysqli('localhost', 'root', '', 'здесь имя твоего датабайз');

if ($db -> connect_errno > 0){
    die('Unable to connect' . $db ->
        connect_error);
}else {
    echo "fine";
}