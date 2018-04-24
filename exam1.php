<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <style media="screen">
  @import url('https://fonts.googleapis.com/css?family=Kanit|Roboto');

    #mainform{
      margin: auto;
      text-align: center;
      font-family: 'Kanit', sans-serif;
    }
    #mainform input[type=submit]{
      margin: 5px 0px 0px 0px;
      font-family: 'Kanit', sans-serif;
      color:#000;
      background-color: #ccc;
      border: 1px solid #000;
    }
    #mainform input[type=submit]:hover{
      color:#ccc;
      background-color: #000;
      cursor: pointer;
    }
    #text{
      margin: 10px 0px 0px 0px;
      font-family: 'Kanit', sans-serif;
      border-radius: 10px;
      /*border-style: dashed;*/
      border:1px solid #ccc;
      text-align: left;
      padding: 10px 0px 10px 10px;
      width: 50%;
    }
  </style>
  <body>
    <form action="#" method="post" id="mainform">
      value 1 : <input type="text" name="v1"><br>
      value 2 : <input type="text" name="v2"><br>
      value 3 : <input type="text" name="v3"><br>
      value 4 : <input type="text" name="v4"><br>
      <input type="submit" name="sbmt" value="ส่งข้อมูล">
    </form>

    <?php

      if(isset($_POST["sbmt"])){
        $data = array ('left-weight,left-distance,right-weight,right-distance,class',
         '5,1,3,2,L',
         '4,2,3,1,B',
         '3,5,2,1,R');


        $input = $_POST["v1"] . "," . $_POST["v2"] . "," . $_POST["v3"] . "," . $_POST["v4"] . ",?";
        array_push($data,$input);

        $fp = fopen('balance_csv.csv', 'w');
          foreach($data as $line){
          $val = explode(",",$line);
          fputcsv($fp, $val);
        }
        fclose($fp);

        $cmd = 'java -classpath "C:\Program Files\Weka-3-7\weka.jar" weka.core.converters.CSVLoader -N "last" balance_csv.csv > balance_unseen_test.arff ';
        exec($cmd,$output);

        // run unseen data -p 5 is class attribute
        $cmd1 = 'java -classpath "C:\Program Files\Weka-3-7\weka.jar" weka.classifiers.trees.J48 -T "balance_unseen_test.arff" -l "balance.model" -p 5'; // show output prediction
        exec($cmd1,$output1);
        
        echo "<div id=text>";
        echo "ข้อมูลที่คุณป้อนของคุณคือ ".substr($data[4],0,7) . "<br>";
        echo "ผลลัพธ์ที่ได้จากการทำนายคือ $output1[8]";
        echo "</div>";
      }


     ?>
  </body>
</html>
