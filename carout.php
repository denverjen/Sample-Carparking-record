<?php
  // start php session
  session_start();
  // check if user is logged in
  if(!isset($_SESSION['uname'])){
    header('Location: login.php');
  }
  // include dbconfig.php
  include_once("include/dbconfig.php");
  // get the id
  $id = $_GET['id'];
  // select the carparking record from the database
  $query = "SELECT *,TIMESTAMPDIFF(SECOND, time_in, NOW()) as time_stay FROM carparking WHERE id = $id";
  $result = mysqli_query($conn, $query);
  $row = mysqli_fetch_assoc($result);
  $time_stay = round( $row['time_stay']/60 ) ;
?>
<html>
  <!-- include header.php -->
  <?php include "header.php" ; ?>
  <body>
    <div class="jumbotron text-center">
      <h1>車輛離開</h1>
      <div class="container text-left">
        <p>車牌號碼：<?php echo $row['carno'] ;?></p>
        <p>車輛類型：<?php echo $row['cartype'] ;?></p>
        <p>入車時間：<?php echo $row['time_in'] ;?></p>
        <p>停留時間：<?php echo $time_stay."分鍾" ;?></p>
        <p>原因：<?php echo $row['code'] ;?></p>
        <p>座：<?php echo $row['blk'] ; echo $row['room'] ;?></p>
        <a href="<?php echo "confirmcarout.php?id=".$id ;?>" class="btn btn-primary">確定離開</a>
        <a href="index.php" class="btn btn-primary">返回</a>
      </div>
    </div>
  <!-- include footer.php -->
  <?php include "footer.php" ;?>
  </body>
</html>
    


