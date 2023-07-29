<?php
session_start();

include("funcs.php");

sschk();

if (!isset($_SESSION["chk_ssid"]) || !isset($_SESSION["kanri_flg"]) || $_SESSION["kanri_flg"] !== 1) {
    // ログインしていないか、管理者権限を持っていない場合は閲覧を許可しない
    // ログインページにリダイレクト
    exit("あなたに閲覧権限はありません。戻るボタンを押して戻ってください");
  }

$pdo = db_conn();      //DB接続関数

//２．データ登録SQL作成
$stmt   = $pdo->prepare("SELECT * FROM gs_user_table"); //SQLをセット
$status = $stmt->execute(); //SQLを実行→エラーの場合falseを$statusに代入

$view=""; //HTML文字列作り、入れる変数
if($status==false) {
  //SQLエラーの場合
  sql_error($stmt);
}else{
  //SQL成功の場合
  while( $r = $stmt->fetch(PDO::FETCH_ASSOC)){ //データ取得数分繰り返す
    $view .= '<p>';
    $view .= '<a href="user_update_view.php?id='.h($r["id"]).'">';
    $view .= h($r["id"])."|".h($r["name"])."|".h($r["lid"])."|".h($r["lpw"])."|".h($r["kanri_flg"])."|".h($r["life_flg"]);
    $view .= '</a>';
    $view .= '<br>';
  }
}

?>


<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>ユーザ一覧</title>
<link rel="stylesheet" href="css/range.css">
<link href="css/bootstrap.min.css" rel="stylesheet">
<style>div{padding: 10px;font-size:16px;}</style>
</head>
<body id="main">
<!-- Head[Start] -->
<header>
  <nav class="navbar navbar-default">
    <div class="container-fluid">
    <div class="navbar-header"><a class="navbar-brand" href="index.php">新規ブックマーク登録</a></div>
    <div class="navbar-header"><a class="navbar-brand" href="user_add.php">新規ユーザ登録</a></div>
    <div class="navbar-header"><a class="navbar-brand" href="login.php">ログイン</a></div>
    <div class="navbar-header"><a class="navbar-brand" href="logout.php">ログアウト</a></div>
    </div>
  </nav>
</header>
<!-- Head[End] -->

<!-- Main[Start] -->
<div>
    <h3>ユーザ一覧</h3>
    <div class="container jumbotron"><?=$view?></div>
</div>
<!-- Main[End] -->

</body>
</html>
