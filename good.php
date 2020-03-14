<?php

require_once('config.php');
require_once('functions.php');


if ($_SERVER['REQUEST_METHOD'] === 'GET') {
  // フォームに入力されたデータの受け取り
  $id =$_GET['id'];
  $good = $_GET['good'];

  if ($good == "1") {
    $good_value = 1;
  } else {
    $good_value = 0;
  }

// データを更新する処理
  $dbh = connectDb();
  $sql = "update tweets set good = :good where id = ;id";
  $stmt = $dbh->prepare($sql);
  $stmt->bindParam(":id", $id, PDO::PARAM_INT);
  $stmt->bindParam(":good_value", $good_value);
  $stmt->execute();  
  $tweet = $stmt->fetch(PDO::FETCH_ASSOC);

//   header('Location: index.php');
// exit;
}