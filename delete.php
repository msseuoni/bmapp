<?php
session_start();

//1. POSTデータ取得
$No   = $_GET["No"];

if (!isset($_SESSION["chk_ssid"]) || !isset($_SESSION["kanri_flg"]) || $_SESSION["kanri_flg"] !== 1) {
    // ログインしていないか、管理者権限を持っていない場合は削除を許可しない
    // ログインページにリダイレクト
    exit("あなたに削除権限はありません。戻るボタンを押して戻ってください");
  }

//2. DB接続します
include("funcs.php");  //funcs.phpを読み込む（関数群）
$pdo = db_conn();      //DB接続関数

//３．データ登録SQL作成
$sql = "DELETE FROM gs_bm_table WHERE No=:No";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':No',$No, PDO::PARAM_INT);  //Integer（数値の場合 PDO::PARAM_INT)
$status = $stmt->execute(); //実行


//４．データ登録処理後
if($status==false){
    sql_error($stmt);
}else{
    redirect("bm_list_view.php");
}

?>
