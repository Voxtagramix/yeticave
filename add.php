<?php
require_once "functions.php";
require_once "data.php";
$connection = connection();
$categories = categories($connection);
if(!isset($_SESSION['user_name']))
{
    $main_page = include_template('403.php',array());
    print_r(
        include_template(
            "layout.php",
                 ['vid' => $categories,
                "main" => $main_page,
                "title" => "Добавление лота"]
        )
    );
}
else {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $e = false;
        $error = array();
        if ($_FILES['image']['name'] == "" || !exif_imagetype($_FILES['image']['tmp_name'])) {
            $e = true;
            $error['image'] = 1;
        } else {
            $error['image'] = 0;
        }
        foreach ($_POST as $index => $item) {
            if ($item == "" || $item == "Выберите категорию" || (($index == 'lot-rate' || $index == 'lot-step') && preg_match('/^\d+$/', $item) === 0)) {
                $e = true;
                $error[$index] = 1;
            } else {
                $error[$index] = 0;
            }
        }
        if ($e) {
            $connection = connection();
            $categories = categories($connection);
            $main_page = include_template('add-lot.php', ['vid' => $categories, 'error' => $error, 'fatal' => true, 'data' => $_POST]);
            print_r(
                include_template(
                    "layout.php",
                    ['vid' => $categories, "main" => $main_page, "page_name" => "Добавление лота"]
                )
            );
        } else {

            $usering=$_SESSION['user_name'];
            $name = $_FILES['image']['name'];
            $to = "img/$name";
            $category1 = $_POST['category'];
            move_uploaded_file($_FILES['image']['tmp_name'], $to);
            $connection = connection();
            $zapros1 = "Insert into lots
    (
     id_lotting,
     id_category,
     id_user,
     id_winner,
     data_start,
     lot_name,
     description,
     img,
     start_price,
     data_over,
     step_price
     )
values
    (
     null,
     (SELECT id_cat from categories where categories.name='$category1'),
     (SELECT id_use from  users where user_name='$usering'),
     NULL,
     now(),
     '" . $_POST['lot-name'] . "',
     '" . $_POST['message'] . "',
     '" . $to . "',
     '" . $_POST['lot-rate'] . "',
     '" . $_POST['lot-date'] . "',
     '" . $_POST['lot-step'] . "'
    );select id_lotting from lots where lot_name='" . $_POST['lot-name'] . "';";
            $connection->multi_query($zapros1);
            $connection->next_result();
            $currentLot = $connection->store_result();
            $ID_Kit = $currentLot->fetch_row()[0];
            header("location:lot.php?id=$ID_Kit");
        }

    } else {
        $is_auth = 1;
        $user_name = "Павел";
        $main_page = include_template('add-lot.php', ['vid' => $category, 'error' => null, 'fatal' => false,]);
        print_r(
            include_template
            (
                "layout.php",
                ['vid' => $category,
                    "is_auth" => $is_auth,
                    "user_name" => $user_name,
                    "main" => $main_page,
                    "title" => "Добавление лота"]
            )
        );
    }
}
?>
