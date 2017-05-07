<!-- hw3_result.php -->

<?php
//form1,2,3の値が渡された時，それぞれ受け取り，それぞれの値を結合する
if (isset($_POST['form1']) && is_array($_POST['form1'])) {
    $form1 = implode(', ', $_POST["form1"]);

  }

if (isset($_POST['form2']) && is_array($_POST['form2'])) {
    $form2 = implode(', ', $_POST["form2"]);
  }

if (isset($_POST['form3']) && is_array($_POST['form3'])) {
    $form3 = implode(', ', $_POST["form3"]);
  }
?>


<html>
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
    <title>アンケート結果</title>

  </head>

  <body>
    <div class="container">
      <div class="page-header">
        <h1>アンケート結果</h1>
      </div>

      <ul class="lead list-group">
        <li class="list-group-item">問１）興味のある研究分野は？ -> [回答]<?php echo $form1;?></li>

        <li class="list-group-item">問２）興味のあるＩＴ系の分野は？ -> [回答]<?php echo $form2;?></li>

        <li class="list-group-item">問３）好きな先生は？ -> [回答]<?php echo $form3;?></li>

    </ul>

    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>

  </body>
</html>
