<!-- hw5/bbs.php -->

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

//フォームの値をMysqlに登録する
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  if (!empty($_POST['name']) && !empty($_POST['comment']) && !empty($_POST['password'])) {    //nameと,comment,passwordの値が空値でない場合
    $insert = $mysqli->query("INSERT INTO `messages` (`name`, `body`, `password`) VALUES ('{$_POST['name']}', '{$_POST['comment']}', '{$_POST['password']}')");
    if (!$insert) {   //queryエラーの場合，エラーを表示する
      printf("Query failed: %s\n", $mysqli->error);
      exit();
    }
  }
}

//データベースの読み込み　id降順
$result = $mysqli->query('SELECT * FROM messages ORDER BY id DESC');
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
    <title>掲示板</title>
  </head>

  <body>
    <div class="container">
      <div class="page-header">
        <h1>BBS Sample</h1>
      </div>

      <form name="bbs" action="bbs.php" method="post">
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
          <?php foreach ($result as $row):　?>　　<!-- テーブルの内容を表示する -->
            <form action="./bbs_edit.php" method="post">
              <tr>
                <td><?= $row['name'] ?></td>
                <td><?= $row['body'] ?></td>
                <td><?= $row['timestamp'] ?></td>
                <td>
                  <input type="password" name="password" class="form-control" size="10">
                  <input type="hidden" name="id" value="<?= $row['id'] ?>">
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
