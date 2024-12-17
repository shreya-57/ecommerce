<?php
    $servername='localhost';
    $username='root';
    $password='';
    $dbname='ecommerce';
    $port=3306;

    $con= mysqli_connect($servername,$username,$password,$dbname,$port);

    if(!$con){
        echo "failed to connect".mysqli_connect_error();
    }
?>