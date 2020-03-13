<?php

require_once('config.php');
require_once('functions.php');

$dbh = connectDb();

$sql = "select * from tweets order by created_at desc";

$stmt = $dbh->prepare($sql);

$stmt->execute();

$tweets = $stmt->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $content = $_POST['content'];
  $errors = [];

  // バリデーション
  if ($content == '') {
  $errors['content'] = 'ツイート内容を入力してください。';
  }

  if (empty($errors)) {
  $sql = "insert into tweets (content, created_at) values (:content, now())";
  $stmt = $dbh->prepare($sql);
  $stmt->bindParam(":content", $content);
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
  <h1>新規Tweet</h1>
  <?php if ($errors) : ?>
    <ul class="error-list">
      <li>
        <?php echo h($errors['content']); ?>
      </li>
    </ul>
  <?php endif; ?>
  <form action="" method="post">
    <p>
      <label for="content">ツイート内容</label><br>
        <textarea name="content" cols="30" rows="5"  placeholder="いまどうしてる？"></textarea>
      <br>
        <input type="submit" value="投稿する">
    </p>
  </form>
  <h2>Tweet一覧</h2><br>
  <?php if (count($tweets)) : ?>
    <ul class="tweet-list">
      <?php foreach ($tweets as $tweet) : ?>
        <li>
          <a href="show.php?id=<?php echo h($tweet['id']) ?>"><?php echo h($tweet['content']); ?></a><br>
          投稿日時: <?php echo h($tweet['created_at']); ?>
          <?php if($tweet['good'] == false) : ?>
            <a href="good.php?id=<?php echo h($tweet['id']) . "&good=1"; ?>" class="good-link"><?php echo '☆'; ?></a>
          <?php else : ?>
            <a href="good.php?id=<?php echo h($tweet['id']) . "&good=0"; ?>" class="bad-link"><?php echo '★'; ?></a>
          <?php endif; ?>
          <hr>
        </li>
      <?php endforeach; ?>
    </ul>
  <?php else : ?>
    <p>投稿されたtweetはありません</p>
  <?php endif; ?>
</body>
</html>