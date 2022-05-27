<?php
require_once "functions.php";
require_once "data.php";
$connection = connection();
$categories = categories($connection);
if($_SERVER['REQUEST_METHOD']=="POST")
{

    $errors = array();
    $e =0;
    foreach ($_POST as $index=>$value)
    {
        $i =$index;
        if($index == "name")
            $i ="имя";
        if($index == "password")
            $i ="пароль";
        if($value==="")
        {
            $errors[$index]="Введите $i";
            $e=1;
        }
        else
        {
            $errors[$index]=0;
        }
    }
    if(!filter_var($_POST['email'],FILTER_VALIDATE_EMAIL)&&$errors['email']===0)
    {
        $errors['email']="Почта не соответствует формату";
        $e=1;
    }
    $query = "SELECT user_name from users where email='{$_POST['email']}'; SELECT user_name from users where  user_name='{$_POST['name']}'";
    $connection->multi_query($query);
    $result1 =$connection->store_result();
    $result = $result1->fetch_array(MYSQLI_ASSOC);
    if($result1->num_rows!==0 && $errors['email']===0)
    {
        $errors['email']="Пользователь с такой почтой уже зарегистрирован";
        $e=1;
    }
    $connection->next_result();
    $result1 =$connection->store_result();
    $result = $result1->fetch_array(MYSQLI_ASSOC);
    if($result1->num_rows!==0 && $errors['name']===0)
    {
        $errors['name']="Пользователь с таким именем уже зарегистрирован";
        $e=1;
    }
    $file = $_FILES['image']['tmp_name'];
    $to = "img/{$_FILES['image']['name']}";
    if($file=="")
    {
        $file = "img/user.png";
        $to = $file;
    }
    else
    {
        $mime = mime_content_type($file);
        if ($mime != 'image/jpeg' && $mime != 'image/png') {
            $errors['image'] = 'Выберите файл формата .png,.jpg,.jpeg';
            $e = 1;
        }
        else {
            if(!$e)
                move_uploaded_file($_FILES['image']['tmp_name'],$to);
        }
    }
    if(!$e)
    {
        $password = password_hash($_POST['password'],PASSWORD_DEFAULT);
        $querys = "INSERT INTO users values (NULL,'{$_POST['name']}','$to','{$_POST['email']}','$password','{$_POST['message']}',now())";
        $connection->query($querys);
        print_r($_FILES);
        $user_name = $_POST['name'];
        $avatar = $to;
        setcookie('user_name',$user_name);
        setcookie('avatar', $avatar);
        header("location:index.php");
    }
    else
    {

        $main_page = include_template('register.php', ['vid' => $categories,"errors"=>$errors]);
        print_r(
            include_template(
                "layout.php",
                ['vid' => $categories,
                    "main" => $main_page,
                    "title" => "Регистрация"
                ]
            )
        );
    }
}
else
{

    $main_page = include_template('register.php', ['vid' => $categories]);
    print_r(
        include_template(
            "layout.php",
            ['vid' => $categories,
                "main" => $main_page,
                "title" => "Регистрация"
            ]
        )
    );
}
$connection->close();
