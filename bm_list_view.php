<?php
session_start();

include("funcs.php");

sschk();

$pdo = db_conn();      //DB接続関数

//２．データ登録SQL作成
// $sql = "SELECT * FROM gs_bm_table;";
// $stmt = $pdo->prepare($sql);
$stmt   = $pdo->prepare("SELECT * FROM gs_bm_table"); //SQLをセット
$status = $stmt->execute(); //SQLを実行→エラーの場合falseを$statusに代入

//３．データ表示
// $view="";
// if($status==false) {
//     //execute（SQL実行時にエラーがある場合）
//   $error = $stmt->errorInfo();
//   exit("SQL_Error:".$error[2]);

// }else{
//   //Selectデータの数だけ自動でループしてくれる
//   //FETCH_ASSOC=http://php.net/manual/ja/pdostatement.fetch.php
//   while( $res = $stmt->fetch(PDO::FETCH_ASSOC)){
//     $view .= '<p>';
//     $view .= $res['No'].','.$res['name'].','.$res['Author'].','.$res['Comment'];
//     $view .= '<p>';
//   }

// }
$view=""; //HTML文字列作り、入れる変数
if($status==false) {
  //SQLエラーの場合
  sql_error($stmt);
}else{
  //SQL成功の場合
  while( $r = $stmt->fetch(PDO::FETCH_ASSOC)){ //データ取得数分繰り返す
    $view .= '<p>';
    $view .= '<a href="bm_update_view.php?No='.h($r["No"]).'">';
    $view .= h($r["No"])."|".h($r["name"])."|".h($r["Author"])."|".h($r["Comment"]);
    $view .= '</a>';
    $view .= '<a class="btn btn-danger" href="delete.php?No='.h($r["No"]).'">';
    $view .= '[<i class="glyphicon glyphicon-remove"></i>削除]';
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
<title>ブックマーク一覧</title>
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
    <div class="navbar-header"><a class="navbar-brand" href="user_list_view.php">ユーザ一覧</a></div>
    <div class="navbar-header"><a class="navbar-brand" href="login.php">ログイン</a></div>
    <div class="navbar-header"><a class="navbar-brand" href="logout.php">ログアウト</a></div>
    </div>
  </nav>
</header>
<!-- Head[End] -->

<!-- Main[Start] -->
<div>
    <h3>ブックマーク一覧</h3>
    <div class="container jumbotron"><?=$view?></div>
</div>
<!-- Main[End] -->

</body>
</html>
