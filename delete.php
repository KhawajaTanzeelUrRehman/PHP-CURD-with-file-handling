<?php
session_start();
include './config.php';
if (isset($_SESSION['accessedId'])) {
    $deleteId = (int) $_SESSION['accessedId'];
    $picPath = $_SESSION['picPath'];

    $query = "SET FOREIGN_KEY_CHECKS=0; ";

    $query .= "DELETE FROM employees WHERE employeeNumber = $deleteId";

    unlink($picPath);


    $exec = mysqli_multi_query($connection, $query);
    if ($exec) {
        $submit = 'delete';
    } else {
        $submit = 'notdel';
    }
    session_unset();
    session_destroy();
    header("Location: ./index.php?submit=$submit");
}
