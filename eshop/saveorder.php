<?php
    require "inc/lib.inc.php";
    require "inc/config.inc.php";
if($_SERVER['REQUEST_METHOD'] == 'POST') {
    if(isset($_POST['name'])) {
        $name = trim(strip_tags($_POST['name']));
    }
    if(isset($_POST['email'])) {
        $email = trim(strip_tags($_POST['email']));
    }
        if(isset($_POST['phone'])) {
        $phone = trim(strip_tags($_POST['phone']));
    }
        if(isset($_POST['address'])) {
        $address = trim(strip_tags($_POST['address']));
    }
}

$oid = $basket['orderid'];
$date = time();
$order = "$name | $email | $phone | $address | $oid | $date\n";
file_put_contents("admin/".ORDERS_LOG, $order, FILE_APPEND);

SaveOrder($date);
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Сохранение данных заказа</title>
</head>
<body>
    <p>Ваш заказ принят.</p>
    <p><a href="catalog.php">Вернуться в каталог товаров</a></p>
</body>
</html>
