<?php
$is_auth = rand(0, 1);
$connection = new mysqli('127.0.0.1', 'root', '', 'shema');
$query="Select * from categories";
$categories_result=$connection->query($query);
$category=$categories_result->fetch_all(MYSQLI_ASSOC);
$query1="Select * FROM lots Inner join categories on lots.id_category=categories.id order by data_start desc";
$lots_result=mysqli_query($connection, $query1);
$lot=mysqli_fetch_all($lots_result, MYSQLI_ASSOC);
?>
