<!-- hw3_form2.php -->

<?php
    if (isset($_POST['form1']) && is_array($_POST['form1'])) {  //form1の値が渡された時
      $form1 = $_POST["form1"];     //form1の値を受け取る
    }
?>

<html>
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
    <title>アンケート2ページ目</title>

  </head>

  <body>
    <div class="container">
      <div class="page-header">
        <h1>問２）興味のあるＩＴ系の分野は？</h1>
      </div>

      <form action="hw3_form3.php" method="post">
        <div class="form-group lead">
          <input type="checkbox" name="form2[]" value="マーケティング/セールス" class="checkbox-inline"> マーケティング/セールス
          <input type="checkbox" name="form2[]" value="コンサルティング" class="checkbox-inline"> コンサルティング
          <input type="checkbox" name="form2[]" value="システム開発系" class="checkbox-inline"> システム開発系
          <input type="checkbox" name="form2[]" value="Web開発系" class="checkbox-inline"> Web開発系
          <input type="checkbox" name="form2[]" value="ハードウェア系" class="checkbox-inline"> ハードウェア系
          <input type="checkbox" name="form2[]" value="その他" class="checkbox-inline"> その他
        <?php
          for($i=0;$i<count($form1);$i++){      //form1の値の個数分ループする
            print "<input type=\"hidden\" name=\"form1[]\" value=\"$form1[$i]\">";    //inputのhiddenでform1の値を渡す
          }
        ?>
        </div>
        <input type="submit" class="btn-primary">
      </form>
    </div>

    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>

  </body>
</html>
