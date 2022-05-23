<?php
require_once('functions.php');
require_once "data.php";


$data_main=['vid'=>$category, 'info'=>$lot];
$main=include_template("index.php", $data_main);
$data_layout=array_merge(['main'=>$main, 'title'=>"Главная"], $data_main);
print include_template("layout.php", $data_layout);


?>
