<pre>
<?php

    if($_SERVER['REQUEST_METHOD']=='POST'){
        print_r($_FILES);
        move_uploaded_file($_FILES["userfile"]["tmp_name"], "upload/" . $_FILES["userfile"]["name"]);
    }
?>
<form action='upload.php' method='post' enctype='multipart/form-data'>
<input type='file' name='userfile'>
<input type='submit'>
</form>
