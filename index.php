<?php
require_once('functions.php');
require_once('data.php');
$page_content = include_template('index.php', [
    'vid' => $vid,
    'info' => $info,
]);
$layout_content = include_template('layout.php', [
    'is_auth' => $is_auth,
    'user_name' => $user_name,
    'content' => $page_content,
    'vid' => $vid,
    'title' => 'Главная страница'
]);
print($layout_content);
?>
