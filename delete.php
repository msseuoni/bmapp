<?php
session_start();

// ログインしているかをチェック
if (!isset($_SESSION["kanri_flg"])) {
    // セッションに"kanri_flg"がセットされていない場合はログインエラー
    echo "Login Error";
    exit; // 処理を中断して終了
}

// 管理フラグが1でない場合は削除失敗のメッセージを表示
if ($_SESSION["kanri_flg"] != 1) {
    echo "削除する権限がありません。";
    exit; // 処理を中断して終了
}

//1. POSTデータ取得
$No   = $_GET["No"];

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
