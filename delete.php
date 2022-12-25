
<?php

    if($_SERVER['REQUEST_METHOD'] === 'POST') {
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

        $sql = "DELETE FROM " . $table . " WHERE id='$id'";
        $result = $conn->query($sql);

        $conn->close();
    }


?>