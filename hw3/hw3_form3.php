<!-- hw3_form3.php -->

<?php
    //form2.phpと同じようにform1,form2の値が渡された時，値を受け取る
    if (isset($_POST['form1']) && is_array($_POST['form1'])) {
      $form1 = $_POST["form1"];
    }

    if (isset($_POST['form2']) && is_array($_POST['form2'])) {
      $form2 = $_POST["form2"];
    }
?>

<html>
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
    <title>アンケート3ページ目</title>

  </head>

  <body>
    <div class="container">
      <div class="page-header">
        <h1>問３）好きな先生は？</h1>
      </div>

      <form action="hw3_result.php" method="post">
        <div class="form-group lead">
          <input type="checkbox" name="form3[]" value="佐々木 淳" class="checkbox-inline"> 佐々木 淳
          <input type="checkbox" name="form3[]" value="高木 正則" class="checkbox-inline"> 高木 正則
          <input type="checkbox" name="form3[]" value="山田 敬三" class="checkbox-inline"> 山田 敬三
        <?php
          //form1,form2の値をhiddenでresult.phpに渡す
          for($i=0;$i<count($form1);$i++){
            print "<input type=\"hidden\" name=\"form1[]\" value=\"$form1[$i]\">";
          }

          for($i=0;$i<count($form2);$i++){
            print "<input type=\"hidden\" name=\"form2[]\" value=\"$form2[$i]\">";
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
