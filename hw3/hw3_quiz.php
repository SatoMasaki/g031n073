<!-- hw3_quiz.php -->


<html>
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
    <title>多肢選択式クイズ</title>
  </head>

  <body>
    <div class="container">
      <div class="page-header">
        <h1>この授業のTAは誰でしょう？</h1>
      </div>

      <form action="hw3_quiz.php" method="post">
        <div class="form-group lead">
          <input type="radio" name="q1" value="さとう"> さとう
          <input type="radio" name="q1" value="かんの"> かんの
          <input type="radio" name="q1" value="ひらの"> ひらの
          <input type="radio" name="q1" value="ふくさか"> ふくさか
        </div>
        <input type="submit" class="btn-primary">
      </form>

      <div class="lead">
        <?php
          if ($_POST['q1'] == NULL) {   //選択されていない場合何も表示しない

          } elseif ($_POST['q1'] === "ひらの") {     //正解(ひらの)が選択された場合正解と表示
            echo "正解.";
          } else {
            echo "不正解．";
          }
        ?>
      </div>
    </div>
  </body>
</html>
