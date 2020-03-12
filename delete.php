<?php

require_once('config.php');
require_once('functions.php');

$id =$_GET['id'];

$dbh = connectDb();
$sql = "select * from tweets where id = :id";
$stmt = $dbh->prepare($sql);
$stmt->bindParam(":id", $id, PDO::PARAM_INT);
$stmt->execute();

$tweets = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$tweet) {
  header('Location: index.php');
  exit;
}

$sql_delete = "delete from tweets where id = :id";
$stmt_delete = $dbh->prepare($sql_delete);
$stmt_delete->bindParam($sql_delete);
$stmt_delete->execute();

header('Location: index.php');