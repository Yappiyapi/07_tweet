<?php

require_once('config.php');
require_once('functions.php');

$id =$_GET['id'];

$dbh = connectDb();



if ($_SERVER['REQUEST_METHOD'] === 'GET') {
  // フォームに入力されたデータの受け取り
  $good = $_GET['good'];

  if ($good == "1") {
    $good_value = 1;
  } else {
    $good_value = 0;
  }

// データを更新する処理
  $sql = "update tweets set good = 1 where id = ;id";
  $sql = "update tweets set good = 0 where id = ;id";
  $stmt = $dbh->prepare($sql);
  $stmt->bindParam(":id", $id, PDO::PARAM_INT);
  $stmt->bindParam(":good", $good);
  $stmt->execute();  
  $tweet = $stmt->fetch();

//   header('Location: index.php');
// exit;
}