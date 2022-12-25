<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>change</title>
    <link rel="stylesheet" href="./css/change.css">
</head>
<body>
    <?php
    
    if ($_GET['id'] == 0 || !empty($_GET['id']))
    {
        $id = $_GET['id'];
        $sercername = "localhost";
        $username = "admin";
        $password = "password";
        $database = "bbase";
        $table = "ttable";

        $conn = new mysqli($sercername, $username, $password, $database);

        if($conn->connect_error){
            die("Connection faild: " . $conn->connect_error);
        }

        $sql = "SELECT * FROM " . $table . " WHERE id='$id'";
        $result = $conn->query($sql);

        $row = mysqli_fetch_assoc($result);

        $name = $row["name"];
        $cost = $row["cost"];
        $info = $row["info"];
        $height = $row['h'];
        $width = $row['w'];
        $img = $row['img'];


        function addFile($row){
            if ($_FILES["item_img"]['name']) {
                $uploaddir = "./uploads/";
                $item_img = $_FILES["item_img"]['name'];
                move_uploaded_file($_FILES['item_img']['tmp_name'], $uploaddir . $item_img);
                $img_link = $uploaddir . $item_img;
                if(($uploaddir . $item_img )!= $uploaddir && $row['img'] != $img_link){
                    if($row['img'] != '') {unlink($row['img']);}
                    return $img_link;
                }
            }
            return false;
        }

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['item_name'];
            $cost = $_POST["cost"];
            $info = $_POST["info"];
            $height = $_POST["h"];
            $width = $_POST["w"];
            $temp_img = addFile($row);

            if($temp_img){
                $img = $temp_img;
            }

            $sql = "UPDATE " . $table . " SET name='$name', cost='$cost', info='$info', h='$height', w='$width', img='$img'
            WHERE id='$id'";

            if($conn->query($sql) === TRUE){
                ?><script>alert('Товар успешно обновлён')</script><?php
            }
            else {
                echo 'ERROR';
                return;
            }
        }

        $conn->close();


        ?>
        <form action="change.php?id=<?= $id ?>" method="post" enctype="multipart/form-data"> 
            <div class="modal-window">
                <a href="../catalog.php" class="close" id='close-modal'>&times;</a>
                <div class="specifications">
                    
                    <img src="../<?= $img ?>" alt="<?= $name ?>">
                    
                    <ul>
                        <li>id: <?= $id ?></li>
                        <li><div class="img"><input type="file" calss="item-img" name="item_img"></div></li>
                        <li>Размеры: <input type="text" name="h" placeholder="Высота" value="<?=$height?>"> x <input type="text" name="w" placeholder="Ширина" value='<?= $width ?>'></li>
                        <li>Имя: <input type="text" class="required-field" name="item_name" placeholder="Название товара" value="<?=$name?>"> </li>
                        <li>Цена: <input type="text" class="required-field" name="cost" placeholder="Цена" value="<?=$cost?>"><p>₽</p></li>
                        <li><textarea name="info" id="" cols="30" rows="10" placeholder="Описание"><?=$info?></textarea></li>
                    </ul> 
                </div>
            </div>
            <input type="submit" class="enter" value="Обновить">
        </form>
        <!-- <script src="../js/create.js"></script>     -->
        <?php
    } 

    else {
        ?><script>alert("Product is not found. Please, check the ID");</script><?php 
    }
    ?>
    
</body>
</html>