<?php
$pw = password_hash('test4',PASSWORD_DEFAULT);
echo $pw."<br>";
var_dump(password_verify("test4", $pw)); // 一致しているかを確認
?>