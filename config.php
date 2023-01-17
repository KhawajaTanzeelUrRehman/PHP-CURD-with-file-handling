<?php
$connection = mysqli_connect('localhost','root','','classicmodels');
if(!$connection) {
    echo 'connection failed ' . mysqli_error();
}
?>