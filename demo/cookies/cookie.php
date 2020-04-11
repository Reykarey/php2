<?php
$user = [
    "login" => "user",
    "pass" => "123",
    "verify" => "no"
];
    $str = serialize($user);
    setcookie("koo", $str);
echo $_COOKIE["koo"];
echo gettype($str);
