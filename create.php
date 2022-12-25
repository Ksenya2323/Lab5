<?php
    $sercername = "localhost";
    $username = "admin";
    $password = "password";
    $database = "bbase";
    $table = "ttable";

    if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        if(!checking()){
            ?><script>alert("Ошибка: товар уже существует.")</script><?php
        }
        else{
            addItem();
            ?><script>alert("Товар успешно добавлен")</script><?php
        }
        
    }

    function checking(){
        global $sercername, $username, $password, $database, $table;
        $conn = new mysqli($sercername, $username, $password, $database);

        if($conn->connect_error){
            die("Connection faild: " . $conn->connect_error);
        }

        $searchName = $_POST["item_name"];

        $sql = "SELECT name FROM " . $table . " WHERE name='$searchName'";
        $result = $conn->query($sql);
        $conn->close();
        if($result->num_rows == 0){
            return true;
        }
        return false;
    }

    function addItem()
    {        
        $item_name = $_POST["item_name"];
        $item_cost = $_POST["cost"];
        $item_info = $_POST["info"];
        $h = $_POST['item_h'];
        $w = $_POST['item_w'];

        global $sercername, $username, $password, $database, $table;
        $conn = new mysqli($sercername, $username, $password, $database);

        if($conn->connect_error){
            die("Connection faild: " . $conn->connect_error);
        }

        $sql = "INSERT INTO " . $table . " (name, info, cost, h, w)
        VALUES('$item_name', '$item_info', '$item_cost', '$h', '$w')";

        if($conn->query($sql) === TRUE){
            $item_id = $conn->insert_id;
        }
        else{
            echo('Error');
            return;
        }

        $uploaddir = "./uploads/";
        $item_img = $_FILES["item_img"]['name'];
        $img = $uploaddir . $item_img;
        if($img != $uploaddir){
            move_uploaded_file($_FILES['item_img']['tmp_name'], $uploaddir . $item_img);
            $sql = "UPDATE " . $table . " SET img='$img' WHERE id='$item_id'";
            if($conn->query($sql) === FALSE){
                echo('ERROR');
            }
        }

        $conn->close();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>create</title>
    <style>
        .catalog-add-form{
            display:flex;
            flex-direction:column;
            align-items:center;
        }
        form{
            width: 500px;
            display:flex;
            flex-direction:column;
        }
    </style>
</head>
<body>
    <div class="main">
        <div class="catalog-add-form">
            <p>Введите данные товара</p>
            <form id="post-element" action="create.php" method="post" enctype="multipart/form-data">
                <input type="text" name="item_name" placeholder="Название товара">
                <div style="display:flex"><input type="text" name="cost" placeholder="Цена"><p style="margin:0">₽</p></div>
                <textarea name="info" id="" cols="30" rows="10" placeholder="Описание"></textarea>
                <input type="text" name="item_h" placeholder="Высота">
                <input type="text" name="item_w" placeholder="Ширина">
                <div class="img">Загрузите изображение товара:<br><input type="file" name="item_img"></div></br>
                <input type="submit" class="enter" value="Создать">
            </form>
            <?php
                function exist(){
                    echo("Ошибка: товар уже существует.");
                }
            ?>
        </div>
    </div>
</body>
</html>