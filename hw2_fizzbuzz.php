<?php
  for ($i=1; $i < 101; $i++) {  //ループカウンタiを設定し1から100までループする
    if ($i % 15 == 0) {         //iを15で割って余り0の時
      echo "FizzBuzz";        //FizzBuzzを出力する

    } elseif ($i % 5 == 0) {    //iを5で割って余り0の時
      echo "Buzz";            //Buzzを出力する

    } elseif ($i % 3 == 0) {    //iを3で割って余り0の時
      echo "Fizz";            //Fizzを出力する

    } else {                    //それ以外の時
      echo $i;           //数値を出力

    }
    echo nl2br("\n");
  }
