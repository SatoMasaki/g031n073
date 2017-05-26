<?php
//データベースに接続
$db_user = 'root';         // ユーザー名
$db_pass = '4caozmy7';     // パスワード
$db_name = 'bbs';          // データベース名

// MySQLに接続
$mysqli = new mysqli('localhost', $db_user, $db_pass, $db_name);
//mysqlの接続エラー処理
if ($mysqli->connect_errno) {
  printf("Connect failed: %s\n", $mysqli->connect_errno);
  exit();
}

//コメントの登録
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  if (!empty($_POST['name']) && !empty($_POST['comment']) && !empty($_POST['password'])) {    //nameと,comment,passwordの値が空値でない場合
    //SQLインジェクション処理
    $thread_id = $mysqli->real_escape_string($_GET['id']);
    $name = $mysqli->real_escape_string($_POST['name']);
    $comment = $mysqli->real_escape_string($_POST['comment']);
    $password = $mysqli->real_escape_string($_POST['password']);
    $insert = $mysqli->query("INSERT INTO `messages` (`thread_id`, `name`, `body`, `password`) VALUES ({$thread_id}, '{$name}', '{$comment}', '{$password}')");
    if (!$insert) {   //queryエラーの場合，エラーを表示する
      printf("Query failed: %s\n", $mysqli->error);
      exit();
    }
  }
}

//GETでthread_idを受け取り、スレッドのコメントの読み込み　messagesのid降順
$query = "SELECT threads.name as thread_name, messages.* FROM threads INNER JOIN messages ON threads.id = messages.thread_id WHERE threads.id = {$_GET['id']} ORDER BY id DESC";
$result = $mysqli->query($query);
$result_count = $mysqli->affected_rows;   //resultの件数を取得
if ($result_count >= 1) {   //取得件数が１件以上の場合、結果を取得
  foreach ($result as $row) {}
} elseif ($result_count == 0) {   //取得件数が０件の場合 スレッド名を取得
  $thread_name = $mysqli->query("SELECT name AS thread_name FROM threads WHERE id = {$_GET['id']}");
  foreach ($thread_name as $row) {}
} else {    //それ以外の場合エラー処理
  printf("Query failed: %s\n", $mysqli->error);
  exit();
}

//接続を閉じる
$mysqli->close();

?>

<html>
<head>
  <meta charset="utf-8">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <title>掲示板</title>
</head>

<body>
  <div class="container">
    <div class="page-header">
      <h1>
        <?= $thread_name = htmlspecialchars($row['thread_name']); ?>
      </h1>
      <div style="text-align: right; margin: -5rem 0 10px;">
        <button type="button" class="btn" onclick="location.href='./threads.php'">スレッド一覧
          <span class="glyphicon glyphicon-arrow-left"></span>
        </button>
      </div>
    </div>

    <!-- コメントの投稿 -->
    <form name="bbs" action="" method="post">
      <table class="table">
        <thead>
          <tr>
            <th>Name</th>
            <th>Comment</th>
            <th colspan="2">Password</th>
          </tr>
        </thead>

        <tbody>
          <tr>
            <td><input type="text" name="name" class="form-control"></td>
            <td><input type="text" name="comment" class="form-control"></td>
            <td><input type="password" name="password" class="form-control"></td>
            <td><input type="submit" class="btn btn-primary" value="Submit" onclick="check()"></td>
          </tr>
        </tbody>
      </table>
    </form>

    <!-- コメントの表示 -->
    <table class="table table-striped">
      <thead>
        <tr>
          <th style="width:15%;">Name</th>
          <th style="width:30%;">Comment</th>
          <th style="width:20%;">投稿日時</th>
          <th>パスワード</th>
          <th>編集</th>
          <th>削除</th>
        </tr>
      </thead>
      <tbody>
        <?php
          foreach ($result as $row):
            //XSS対策
            $name = htmlspecialchars($row['name']);
            $body = htmlspecialchars($row['body']);
            $timestamp = htmlspecialchars($row['timestamp']);
            $id = htmlspecialchars($row['id']);
            $thread_id = htmlspecialchars($row['thread_id']);
          ?>
          <!-- コメントの削除・編集form -->
          <form action="./edit.php" method="post">
            <tr>
              <td><?= $name ?></td>
              <td><?= $body ?></td>
              <td><?= $timestamp ?></td>
              <td>
                <input type="password" name="password" class="form-control" size="10">
                <input type="hidden" name="id" value="<?= $id ?>">
                <input type="hidden" name="thread_id" value="<?= $thread_id ?>">
              </td>
              <td>
                <input type="submit" name="bbs_ope" value="編集" class="btn btn-success">
              </td>
              <td>
                <input type="submit" name="bbs_del" value="削除" class="btn btn-danger">
              </td>
            </tr>
          </form>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>

  <!-- 文字入力がない場合の警告ポップアップ -->
  <script language="JavaScript">
  function check() {
    if(document.bbs.name.value == "" || document.bbs.comment.value == "" || document.bbs.password.value == "") { //formのnameかcommentの値が空欄だった場合
      alert("Name・comment・passwordを記入してください.");    //alertを表示する
      return ;
    }
  }
  </script>

</body>
</html>
