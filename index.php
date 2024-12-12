<p>Test</p>
<?php
   // start php session
   session_start();
   // check if user is logged in
   if(!isset($_SESSION['uname'])){
     header('Location: login.php');
   }

  // Table carparking
  // CREATE TABLE carparking (
  //  id int(11)  NOT NULL AUTO_INCREMENT,
  //  carno varchar(50) NOT NULL,
  //  cartypes varchar(50) NOT NULL,
  //  time_in DATETIME,
  //  time_out DATETIME,
  //  code VARCHAR(50),
  //  room VARCHAR(50),
  //  parking INT DEFAULT 1 ,
  //  overtime INT,
  //  PRIMARY KEY ( id ),
  // INDEX park_index (parking, id)
  // ) ;
  // include dbconfig.php
  include_once("include/dbconfig.php");
  // get no. of car where parking = 1 
  $query = "SELECT *,TIMESTAMPDIFF(SECOND,  time_in, NOW()) as time_stay FROM carparking WHERE parking = 1 order by time_in desc";
  $result = mysqli_query($conn, $query);
  $rows = mysqli_num_rows($result);
  $nocarparking = $rows ;
  $noovertime = 0 ;
  // count no. of car time_stay >= 30
  while($row = mysqli_fetch_assoc($result)) {
    if ( round( $row['time_stay'] /60 ) >= 30 ) {
      $noovertime = $noovertime + 1 ;
    }
  }
  $headermessage = "停泊車輛 : ".strval( $nocarparking)." 超時車輛 : ".strval( $noovertime ) ;
  mysqli_data_seek($result, 0) ;
?>

<html>
<!-- include header.php -->
<?php 
  include "header.php" ;
?>
<script>
// refresh the page every 10 seconds
setInterval(function(){
  window.location.reload();
}, 30000);
</script>
<body>
  <div class="jumbotron text-center">
    <h1><?php echo APP_NAME ; ?></h1>
    <p><?php echo APP_USER ; ?></p>
    <a href="carin.php" class="btn btn-primary">入車</a>
    <a href="login.php" class="btn btn-primary">登出</a>
    <a href="index.php" class="btn btn-primary">刷新</a>
    <a href="carparkhistory.php" class="btn btn-primary">紀錄</a>
    <a href="printrange.php" class="btn btn-primary">列印</a>
  </div>
  <!-- list the carparking records -->
  <div class="container">
    <div class="row">
      <div class="col-sm-12 center">
        <!-- center the table content -->
        <p><?php echo $headermessage ;?></p>
        <table class="table table-hover table-striped table-bordered">
          <thead>
            <tr>
              <td>車號</td>
              <td>入車時間</td>              
              <td>停車時間</td>
              <td>操作</td>
            </tr>
          </thead>
          <tbody>
            <?php
            while($row = mysqli_fetch_assoc($result)) {
              $strDate = date("Y-m-d", strtotime($row['time_in']));
              $strTime = date("H:i:s", strtotime($row['time_in']));
              $stay_mintues = round($row['time_stay']/60)  ;
              $strMintue = floor($row['time_stay']/60). "分鐘";
              echo "<tr>";
              echo "<td>". $row['carno']. "</td>";
              // echo "<td>". $row['cartype']. "</td>";
              echo "<td>". $strDate. "<br>". $strTime. "</td>";
              if ($stay_mintues > 30) {
                echo "<td><FONT COLOR=red>". $strMintue. "</FONT></td>";
              } else {
                echo "<td>". $strMintue. "</td>";
              }
              // echo "<td>". $row['code']. "</td>";
              echo "<td><a href='carout.php?id=". $row['id']."' class='btn btn-primary'>出車</a>" ;
              echo "<br><a href='car_info.php?id=". $row['id']."' class='btn btn-danger'>資料</a>" ;
              echo "</td>" ;
              echo "</tr>";
            }
            ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
  <?php include "footer.php" ;?>
</body>
</html>
