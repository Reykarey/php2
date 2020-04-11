<?php
    // подключение библиотек
    require "inc/lib.inc.php";
    require "inc/config.inc.php";
if($_SERVER['REQUEST_METHOD'] == 'GET') {
    if(isset($_GET['id'])) {
        $id = (int)$_GET['id'];
    }
}
$count = 1;
Add2Basket($id);
header("Location: catalog.php");
