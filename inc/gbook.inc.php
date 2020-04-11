<?php
/* Основные настройки */
define('DB_HOST', 'localhost');
define('DB_LOGIN', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'gbook');
$link = mysqli_connect(DB_HOST, DB_LOGIN, DB_PASSWORD, DB_NAME);
if(!$link) {
    echo "Error: " . mysqli_connect_errno() . ":" . mysqli_connect_error();
}
/* Основные настройки */
/* Сохранение записи в БД */
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    if(isset($_POST['name'])) {
        $name = trim(strip_tags($_POST['name']));
    }
    if(isset($_POST['email'])) {
        $email = trim(strip_tags($_POST['email']));
    }
    if(isset($_POST['msg'])) {
        $msg = strip_tags($_POST['msg']);
    }
//header("Location: " . $_SERVER["PHP_SELF"]);
//exit;
}

if(isset($name) && isset($email) && isset($msg)) {
    $sql = "INSERT INTO msgs (name, email, msg) VALUES ('$name', '$email', '$msg')";
    $result = mysqli_query($link, $sql);
    if(!$result){
        echo "Errorrrr: " . mysqli_error($link);
    }
}
/* Сохранение записи в БД */

/* Удаление записи из БД */
if($_SERVER['REQUEST_METHOD'] == 'GET'){
    $del = (int)$_GET['del'];
}
$sql_del = "DELETE FROM msgs WHERE id = $del";
$delete = mysqli_query($link, $sql_del);
if(!$delete){
    echo "Error_delete:" . mysqli_error($link);
}
/* Удаление записи из БД */
?>
<h3>Оставьте запись в нашей Гостевой книге</h3>

<form method="post" action="<?= $_SERVER['REQUEST_URI']?>">
Имя: <br /><input type="text" name="name" /><br />
Email: <br /><input type="text" name="email" /><br />
Сообщение: <br /><textarea name="msg"></textarea><br />

<br />

<input type="submit" value="Отправить!" />

</form>

<?php
/* Вывод записей из БД */
$sql = "SELECT id, name, email, msg, datetime as dt FROM msgs ORDER BY id DESC";
$result_out = mysqli_query($link, $sql);

mysqli_close($link);

$rows_count = mysqli_num_rows($result_out);
echo "<p> Вcего записей: $rows_count <br/><br/>";

$row = mysqli_fetch_all($result_out, MYSQLI_ASSOC);
//      echo "<pre>";
//print_r($row);

foreach($row as $r):
?>
<p><a href="mailto:<?=$r['email']?>"> <?=$r['name']?> </a> <?=$r['dt']?> написал:<br/><?=$r['msg']?></p>
<p align="right">
<a href="<?=$_SERVER['REQUEST_URI']?>/index.php?id=gbook&del=<?=$r['id']?>">Удалить</a>
<?
endforeach;
/* Вывод записей из БД */
?>
