<?php
    // подключение библиотек
    require "secure/session.inc.php";
    require "../inc/lib.inc.php";
    require "../inc/config.inc.php";
if($_SERVER['REQUEST_METHOD'] == 'POST') {
    if(isset($_POST['title'])) {
        $title = trim(strip_tags($_POST['title']));
    }
    if(isset($_POST['author'])) {
        $author = trim(strip_tags($_POST['author']));
    }
    if(isset($_POST['pubyear'])) {
        $pubyear = (int)$_POST['pubyear'];
    }
    if(isset($_POST['price'])) {
        $price = (int)$_POST['price'];
    }
}
if(!AddItemToCatalog($title, $author, $pubyear, $price)) {
    echo "Произошла ошибка при добавлении товара в каталог!";
} else {
    header("Location: add2cat.php");
    exit("Товар успешно добавлен!");
}
