<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/catalog.css">
    <title>catalog</title>
</head>
<body>
    <div class="container">
    <?php
    $sercername = "localhost";
    $username = "admin";
    $password = "password";
    $database = "bbase";
    $table = "ttable";

    $conn = new mysqli($sercername, $username, $password, $database);

    if($conn->connect_error){
        die("Connection faild: " . $conn->connect_error);
    }

    $sql = "SELECT * FROM " . $table;
    $result = $conn->query($sql);

    if($result->num_rows > 0){
        while($row = mysqli_fetch_assoc($result)){
            $name = $row['name'];
            $cost = $row['cost'];
            $id = $row['id'];
            $info = $row['info'];
            $h = $row['h'];
            $w = $row['w'];
            $img = $row['img'];
            ?>
            <div class="cont">
                <div class="Pop" id="<?= $id ?>">                  <!-- текст слева -->
                    <div class="PopBlock">
                        <div class="Nehz">
                            <?= $name ?>
                        </div>
                        <div class="NehZ1">
                            <?= $info ?>
                        </div>
                        <div>
                            <?= $h ?> x <?= $w ?>
                        </div>
                        <div class="Nehz">
                            <?= $cost ?> руб.
                        </div>
                    </div>
                    <div class="slide-img">
                        <img src="<?= $img ?>">
                    </div>
                    <a href="change.php?id=<?= $id ?>" class="change">Change</a>
                    <button class="delete" onclick="DeleteItemById(<?= $id ?>)">Delete</button>
                </div>
            </div>
            
            <?php
        }
    }
    else{
        echo "none products";
    }

    $conn->close();

    
    ?>
    </div>
    <script src="./js/delete.js"></script>
</body>
</html>