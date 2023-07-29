<?php
session_start();
// ログインしているかをチェック
if (!isset($_SESSION["kanri_flg"])) {
  // セッションに"kanri_flg"がセットされていない場合はログインエラー
  echo "Login Error";
  exit; // 処理を中断して終了
}

//1. POSTデータ取得
$name = $_POST['name'];
$Author = $_POST['Author'];
$Comment = $_POST['Comment'];

//2. DB接続します
try {
  //Password:MAMP='root',XAMPP=''
  $pdo = new PDO('mysql:dbname=msseuoni_mss_db;charset=utf8;host=mysql57.msseuoni.sakura.ne.jp','msseuoni','msseuoni-5050');
  // $pdo = new PDO('mysql:dbname=mss_db;charset=utf8;host=localhost','root','');
} catch (PDOException $e) {
  exit('DB Connection Error:'.$e->getMessage());
}


//３．データ登録SQL作成
$stmt = $pdo->prepare("INSERT INTO `gs_bm_table`(name,Author,Comment,date)VALUES(:name, :Author, :Comment, sysdate());");
$stmt->bindValue(':name', $name, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':Author', $Author, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':Comment', $Comment, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$status = $stmt->execute();

//４．データ登録処理後
if($status==false){
  //SQL実行時にエラーがある場合（エラーオブジェクト取得して表示）
  $error = $stmt->errorInfo();
  exit("SQL_ERROR:".$error[2]);
}else{
  //５．index.phpへリダイレクト
  header("Location: index.php");
  exit();
}
?>
