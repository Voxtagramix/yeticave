<?php
require_once "functions.php";
require_once "data.php";
$ID_base=0;
$is_auth = rand(0, 1);
$user_name = 'Paul';
if(isset($_GET["id"]))
{
    $ID_base = $_GET["id"];
    foreach ($lot as $lots)
    {
        if (intval($lots['id_lotting']) == $ID_base)
        {
            $currentLot = $lots;
        }
        else
        {
            header("404.php");
        }
    }
}

$page_cont = include_template('lot.php', ['info' => $lot, 'vid' => $category, 'currentLot' => $currentLot, 'is_auth' => $is_auth]);
$layout_content = include_template('layout.php', [
    'main' => $page_cont,
    'vid' => $category,
    'is_auth' => $is_auth,
    'user_name' => $user_name,
    'title' => $currentLot["lot_name"]]);

print ($layout_content);
?>

