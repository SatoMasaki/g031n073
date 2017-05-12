<!-- hw4/bbs.php -->

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
  if (!empty($_POST['name']) && !empty($_POST['comment'])) {    //nameとcommentの値が空値でない場合
    $insert = $mysqli->query("INSERT INTO `messages` (`name`, `body`) VALUES ('{$_POST['name']}', '{$_POST['comment']}')");
    if (!$insert) {   //queryエラーの場合，エラーを表示する
      printf("Query failed: %s\n", $mysqli->error);
      exit();
    }
  }
}

//データベースの読み込み　id降順
$result = $mysqli->query('select * from messages ORDER BY id DESC');
if (!$result) {   //queryエラーの場合，エラーを表示する
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
              <th colspan="2">Comment</th>
            </tr>
          </thead>

          <tbody>
            <tr>
              <td><input type="text" name="name" class="form-control"></td>
              <td><input type="text" name="comment" class="form-control"></td>
              <td><input type="submit" class="btn btn-primary" value="Submit" onclick="check()"></td>
            </tr>
          </tbody>
        </table>
      </form>

      <table class="table table-striped">
        <thead>
          <tr>
            <th style="width:250px;">Name</th>
            <th style="width:600px;">Comment</th>
            <th>TimeStamp</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($result as $row):  //テーブルの内容を表示する?>
            <tr>
              <td><?= $row['name'] ?></td>
              <td><?= $row['body'] ?></td>
              <td><?= $row['timestamp'] ?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>

    <!-- 文字入力がない場合の警告ポップアップ -->
    <script language="JavaScript">
    function check() {
        if(document.bbs.name.value == "" || document.bbs.comment.value == "") { //formのnameかcommentの値が空欄だった場合
          alert("Nameとcommentを記入してください.");    //alertを表示する
          return false;
        }
    }
    </script>
  </body>
</html>
