<?php
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
function include_template($name, $data) {
    $name = 'templates/' . $name;
    $result = '';
    if (!file_exists($name)) {
        return $result;
    }
    ob_start();
    extract($data);
    require($name);
    $result = ob_get_clean();
    return $result;
}
?>

