<?php
session_start();
if (isset($_POST['deleteButton'])) {
    $_SESSION['accessedId'] = $_POST['deleteId'];
    $_SESSION['picPath'] = $_POST['picPath'];

    if ($_POST['deleteId']) {
        header('Location: ./delete.php');
    }
} else if (isset($_POST['editButton'])) {
    $_SESSION['accessedId'] = $_POST['editId'];
    $_SESSION['picPath'] = $_POST['picPath'];
    $_SESSION['name'] = $_POST['name'];
    if ($_POST['editId']) {
        header("Location: ./update.php");
    }
}
