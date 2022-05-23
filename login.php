<?php
require_once "functions.php";
require_once "data.php";
$connection=connection();
$categories = categories($connection);

if($_SERVER['REQUEST_METHOD']=="POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $errors = array();
    $e = 0;
    foreach ($_POST as $index => $value) {
        if ($value == "") {
            $errors[$index] = "Введите $index";
            $e = 1;
        } else {
            $errors[$index] = 0;
        }
    }
    $zapros1 = "SELECT user_name, password, avatar from users where email='$email'";
    $result1 = $connection->query($zapros1);
    if ($result1->num_rows === 0 && $errors['email'] === 0) {
        $errors['email'] = "Пользователь с такой почтой не найден";
        $e = 1;
    }
    $user = $result1->fetch_array();
    if (($password != $user['password']) && $errors['password'] === 0) {
        $errors['password'] = "Неверный пароль";
        $e = 1;
    }
    if (!$e) {
        $user_name = $user['user_name'];
        $avatar = $user['avatar'];
        session_start();
        $_SESSION['user_name'] = $user_name;
        $_SESSION['avatar'] = $avatar;
        header("location:index.php");
    } else {
        $main_page = include_template('login.php', ['vid' => $categories, "errors" => $errors]);
        print_r(
            include_template(
                "layout.php",
                ['vid' => $categories,
                    "main" => $main_page,
                    "title" => "Авторизация"]
            )
        );
    }
}
else
{

    $main_page = include_template('login.php', ['vid' => $categories]);
    print_r(
        include_template(
            "layout.php",
            ['vid' => $categories,
                "main" => $main_page,
                "title" => "Авторизация"]
        )
    );
}

?>
