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

// if(!$tweet) {
//   header('Location: index.php');
//   exit;
// }


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $content = $_POST['content'];
  $errors = [];

  // バリデーション
  if ($content == '') {
    $errors['content'] = '本文を入力してください。';
  }

  if ($content == $tweets['content']) {
    $errors['content'] = '本文の内容を変更してください。';
  }

  if (empty($errors)) {
    $dbh = connectDb();
    $sql = "update tweets set content = :content, created_at = now() where id = :id";
  $stmt = $dbh->prepare($sql);
  $stmt->bindParam(":content", $content);
  $stmt->bindParam(":id", $id, PDO::PARAM_INT);
  $stmt->execute();

  header('Location: index.php');
  exit;
  }
}

?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Tweetアプリ</title>
  <link rel="stylesheet" href="css/style.css">
</head>
<body>
  <h1>tweetの編集</h1>
  <p><a href="index.php">戻る</a></p>
  <?php if ($errors) : ?>
    <ul class="error-list">
      <?php foreach ($errors as $error) : ?>
        <li>
          <?php echo h($error); ?>
        </li>
      <?php endforeach; ?>
    </ul>
  <?php endif; ?>
  <form action="" method="post">
    <p>
      <label for="content">ツイート内容</label><br>
        <textarea name="content" cols="30" rows="5"><?php echo h($tweet['content']); ?></textarea>
      <br>
        <input type="submit" value="編集する">
    </p>
  </form>
</body>
</html>