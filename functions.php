<?php
require_once('data.php');
function include_template($name, $data): string
{
    $is_auth = isset($_COOKIE['user_name']);
    $user_name = $_COOKIE['user_name']??"";
    $avatar = $_COOKIE['avatar']??"";
    $data['is_auth'] = $is_auth;
    $data['user_name']=$user_name;
    $data['avatar'] = $avatar;
    $name = 'templates/'.$name;
    $result = '!!!';
    if(!file_exists($name)) {
        return $result;
    }
    ob_start();
    extract($data);
    require($name);
    $result = ob_get_clean();
    return $result;
}
$is_auth = rand(0, 1);
function format_sum(int $number):string
{
    $decimals = 0;
    $dec_point = ".";
    $thousands_sep = " ";

    $result = number_format(
        ceil($number),
        $decimals,
        $dec_point,
        $thousands_sep
    );

    return $result . '<b class="rub">р</b>';
}
function timer()
{
    $date=strtotime('2022-05-13 24:00');
    $nowtime= time();
    $difference=$date-$nowtime;
    return gmdate('H:i', $difference);
}

function connection(): mysqli
{
    return new mysqli('127.0.0.1','root','','shema');
}
function categories(mysqli $connection): array
{
    $query = "Select * from categories order by id_cat";
    $category_result = $connection->query($query);
    return $category_result->fetch_all(MYSQLI_ASSOC);
}


?>

