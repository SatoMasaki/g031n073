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

//新規スレッドの作成
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  if (!empty($_POST['name']) && !empty($_POST['password'])) {    //nameと,comment,passwordの値が空値でない場合
    //SQLインジェクション処理
    $name = $mysqli->real_escape_string($_POST['name']);
    $password = $mysqli->real_escape_string($_POST['password']);
    $insert = $mysqli->query("INSERT INTO `threads` (`name`, `password`) VALUES ('{$name}', '{$password}')");
    if ($insert) {   //スレッドが作成できた場合、メッセージの登録画面へ遷移
      header("location: ./new_message.php");
    } else {    //それ以外の場合エラー処理
      printf("Query failed: %s\n", $mysqli->error);
      exit();
    }
  }
}

// スレッドの削除
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  if (isset($_POST['delete'])) {    //passwordとidが一致の場合delete
    $delete = $mysqli->query("DELETE threads, messages from threads INNER JOIN messages ON threads.id = messages.thread_id where threads.id = {$_POST['id']} AND threads.password = '{$_POST['password']}'");
    $delete_count = $mysqli->affected_rows;   //deleteの件数を取得
    if ($delete_count >= 1) {   //削除ができた場合
      print '<script>
      alert("削除しました．");
      location.href = "./threads.php";
      </script>';
    } elseif ($delete_count == 0) {   //パスワードが違う時エラーとを表示
      print '<script>
      alert("パスワードが違います");
      location.href = "./threads.php";
      </script>';
    } else {    //それ以外の場合のエラー処理
      printf("Connect failed: %s\n", $mysqli->connect_errno);
      exit();
    }
  }
}

//スレッドの読み込み　id降順
$result = $mysqli->query('SELECT * FROM threads ORDER BY id DESC');
if (!$result) {    //queryエラーの場合，エラーを表示する
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
  <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
  <title>掲示板</title>
</head>

<body>
  <div class="container">
    <div class="page-header">
      <h1>スレッド一覧</h1>
    </div>

    <!-- 新規スレッドの作成 -->
    <form name="thread" action="" method="post">
      <table class="table">
        <thead>
          <tr>
            <th>スレッド名</th>
            <th colspan="2">Password</th>
          </tr>
        </thead>

        <tbody>
          <tr>
            <td><input type="text" name="name" class="form-control"></td>
            <td><input type="password" name="password" class="form-control"></td>
            <td><input type="submit" class="btn btn-primary" value="Submit" onclick="check()"></td>
          </tr>
        </tbody>
      </table>
    </form>

    <!-- スレッドの表示 -->
    <table class="table table-striped table-hover">
      <thead>
        <tr>
          <th style="width:30%;">スレッド名</th>
          <th style="width:30%;">作成日時</th>
          <th>パスワード</th>
          <th>削除</th>
        </tr>
      </thead>
      <tbody>
        <?php
        foreach ($result as $row):
          //XSS対策
          $id = htmlspecialchars($row['id']);
          $name = htmlspecialchars($row['name']);
          $timestamp = htmlspecialchars($row['timestamp']);
          ?>

          <!-- スレッドの削除form -->
          <form action="" method="post">
            <tr data-href="./messages.php?id=<?= $id ?>">
              <td><?= $name ?></td>
              <td><?= $timestamp ?></td>
              <td>
                <input type="password" name="password" class="form-control">
                <input type="hidden" name="id" value="<?= $id ?>">
              </td>
              <td>
                <input type="submit" name="delete" value="削除" class="btn btn-danger">
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
    if(document.thread.name.value == "" || document.bbs.password.value == "") { //新規スレッドフォームのnameかpasswordの値が空だった場合
      alert("Name・passwordを記入してください.");    //alertを表示する
      return ;
    }
  }
  </script>
  <!-- テーブルにリンクを貼る -->
  <script>
  jQuery(function($) {
    $('tr[data-href]').addClass('clickable')
    .click(function(e) {
      if(!$(e.target).is('input')){
        window.location = $(e.target).closest('tr').data('href');
      };
    });
  });
  </script>

</body>
</html>
