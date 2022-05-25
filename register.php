<?php
require_once "functions.php";
require_once "data.php";
$connection=connection();
$categories = categories($connection);
if($_SERVER['REQUEST_METHOD']=="POST")
{
    $email=$_POST['email'];
    $password=$_POST['password'];
    $user_name=$_POST['name'];
    $contacts=$_POST['message'];
    $errors=array();
    $e=0;
    foreach($_POST as $index => $value)
    {
        if($value == "")
        {
            $errors[$index]="Введите $index";
            $e=1;
        }
        else
        {
            $errors[$index]=0;
        }
    }

    $zapros ="SELECT email from users where email='$email'";
    $result=$connection->query($zapros);
    $zapros2 ="SELECT email from users where contacts='$contacts'";
    $result2=$connection->query($zapros2);
    if($result->num_rows!= 0)
    {
        $errors['email']="Пользователь с такой почтой уже существует";
        $e=1;
    }
    if($result2->num_rows != 0)
    {
        $errors['message']="Уже использованный номер телефона";
        $e=1;
    }

    if($e!=1)
    {

            $zapros1="INSERT INTO users (id_use, user_name, avatar, email, password, contacts, date_reg)
              VALUES(null, '".$_POST['name']."','img/me.jpg','".$_POST['email']."','".$_POST['password']."','".$_POST['message']."',now())";
            $result1=$connection->query($zapros1);
            header("location: index.php");

    }

    else
    {
        $main_page = include_template('register.php', ['vid' => $categories, 'errors' => $errors]);
        print_r(
            include_template(
                "layout.php",
                ['vid' => $categories, "main" => $main_page, "title" => "Регистрация"]
            )
        );
    }

}
else
{
    $main_page = include_template('register.php', ['vid' => $categories]);
    print_r(
        include_template
        (
            "layout.php",
            ['vid' => $categories,
                "main" => $main_page,
                "title" => "Регистрация"]
        )
    );
}
?>
