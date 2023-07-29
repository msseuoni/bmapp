<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>本ブックマーク登録アプリ</title>
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <style>div{padding: 10px;font-size:16px;}</style>
</head>
<body>

<?php
session_start();
include("funcs.php");
sschk();
//1.  DB接続します
try {
  //Password:MAMP='root',XAMPP=''
  $pdo = new PDO('mysql:dbname=msseuoni_mss_db;charset=utf8;host=mysql57.msseuoni.sakura.ne.jp','msseuoni','msseuoni-5050');
  // $pdo = new PDO('mysql:dbname=mss_db;charset=utf8;host=localhost','root','');
} catch (PDOException $e) {
  exit('DB Connection Error'.$e->getMessage());
}

//２．データ登録SQL作成
$sql = "SELECT * FROM gs_user_table;";
$stmt = $pdo->prepare($sql);
$status = $stmt->execute();

//３．データ表示
$view="";
if($status==false) {
    //execute（SQL実行時にエラーがある場合）
  $error = $stmt->errorInfo();
  exit("SQL_Error:".$error[2]);

}else{
  //Selectデータの数だけ自動でループしてくれる
  //FETCH_ASSOC=http://php.net/manual/ja/pdostatement.fetch.php
  while( $res = $stmt->fetch(PDO::FETCH_ASSOC)){
    $view .= '<p>';
    $view .= $res['id'].','.$res['name'].','.$res['lid'].','.$res['lpw'];
    $view .= '<p>';
  }

}
?>

<!-- Head[Start] -->
<header>
  <nav class="navbar navbar-default">
    <div class="container-fluid">
    <div class="navbar-header"><a class="navbar-brand" href="bm_list_view.php">ブックマーク一覧</a></div>
    <div class="navbar-header"><a class="navbar-brand" href="user_list_view.php">ユーザ一覧</a></div>
    <div class="navbar-header"><a class="navbar-brand" href="login.php">ログイン</a></div>
    <div class="navbar-header"><a class="navbar-brand" href="logout.php">ログアウト</a></div>
    </div>
  </nav>
</header>
<!-- Head[End] -->

<!-- Main[Start] -->
<form method="post" action="user_insert.php">
  <div class="jumbotron">
   <fieldset>
    <legend>新規ユーザ登録</legend>
     <label>ユーザ名：<input type="text" name="name"></label><br>
     <label>ID：<input type="text" name="lid"></label><br>
     <label>Pass：<input type="text" name="lpw"></label><br>
     <input type="submit" value="送信">
    </fieldset>
  </div>
</form>



</body>
</html>
