<?php
function AddItemToCatalog($title, $author, $pubyear, $price) {
    global $link;
    $sql = "INSERT INTO catalog(title, author, pubyear, price) VALUES(?, ?, ?, ?)";
    $stmt = mysqli_prepare($link, $sql);
        if(!$stmt) return false;
    mysqli_stmt_bind_param($stmt, "ssii", $title, $author, $pubyear, $price);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    return true;
}
function SelectAllItems() {
    global $link;
    $sql = "SELECT id, title, author, pubyear, price FROM catalog";
    $result = mysqli_query($link, $sql);
        if(!$result) return false;
    $items = mysqli_fetch_all($result, MYSQLI_ASSOC);
    mysqli_free_result($result);
    return $items;
}

function Savebasket() {
    global $basket;
    $basket = base64_encode(serialize($basket));
    setcookie('basket', $basket,  0x7FFFFFFF);
}
function basketInit() {
    global $basket, $count;
    if(!isset($_COOKIE['basket'])) {
        $basket = ['orderid' => uniqid()];
        Savebasket();
    } else {
        $basket = unserialize(base64_decode($_COOKIE['basket']));
        $count = count($basket) -1;
    }
}
function Add2Basket($id) {
    global $basket;
    $basket[$id] = 1;
    Savebasket();
}

function result2Array($data){
    global $basket;
    $arr = [];
    while($row = mysqli_fetch_assoc($data)){
        $row['quantity'] = $basket[$row['id']];
        $arr[] = $row;
    }
    return $arr;
}
function myBasket(){
    global $link, $basket;
    $goods = array_keys($basket);
    array_shift($goods);
    if(!$goods)
        {return false;}
    $ids = implode(",", $goods);
    $sql = "SELECT id, author, title, pubyear, price FROM catalog WHERE id IN ($ids)";
    if(!$result = mysqli_query($link, $sql))
        {return false;}
    $items = result2Array($result);
    mysqli_free_result($result);
    echo "<pre>";
    print_r($items);
    return $items;
}
function deleteItemFromBasket($id) {
    global $basket;
    unset($basket[$id]);
    Savebasket();
}

function SaveOrder($datetime) {
    global $link, $basket;
    $goods = myBasket();
    $stmt = mysqli_stmt_init($link);
    $sql = "INSERT INTO orders (title, author, pubyear, price, quantity, orderid, datetime)
            VALUES (?, ?, ?, ?, ?, ?, ?)";
        if(!mysqli_stmt_prepare($stmt, $sql)) {
            return false;
        }
    foreach($goods as $item) {
        mysqli_stmt_bind_param($stmt, "ssiiisi", $item['title'], $item['author'], $item['pubyear'], $item['price'], $item['quantity'], $basket['orderid'], $datetime);
        mysqli_stmt_execute($stmt);
    }
    mysqli_stmt_close($stmt);
    setcookie('basket', "",  1);
    return true;
}
function getOrders(){
          global $link;
          if(!is_file(ORDERS_LOG))
            {return false;}
        $orders = file(ORDERS_LOG);
        $allorders = [];
          foreach ($orders as $order) {
              list($name, $email, $phone, $address, $orderid, $date) = explode(" | ", trim($order));

              $orderinfo = [];

        $orderinfo["name"] = $name;
        $orderinfo["email"] = $email;
        $orderinfo["phone"] = $phone;
        $orderinfo["address"] = $address;
        $orderinfo["orderid"] = $orderid;
        $orderinfo["date"] = $date;

        $sql = "SELECT title, author, pubyear, price, quantity FROM orders WHERE orderid='$orderid'";
        if(!$result = mysqli_query($link, $sql))
            {return false;}
        $items = mysqli_fetch_all($result, MYSQLI_ASSOC);
        mysqli_free_result($result);

        $orderinfo["goods"] = $items;
        $allorders[] = $orderinfo;
          }
        return $allorders;
        }
