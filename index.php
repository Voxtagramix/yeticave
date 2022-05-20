<?php
require_once('functions.php');
require_once "data.php";
$is_auth = rand(0, 1);
$user_name = 'Павел'; // укажите здесь ваше имя

$data_main=['vid'=>$category, 'info'=>$lot];
$main=include_template("index.php", $data_main);
$data_layout=array_merge(['is_auth'=>$is_auth, 'user_name'=>$user_name, 'main'=>$main, 'title'=>"Главная"], $data_main);
print include_template("layout.php", $data_layout);


?>
