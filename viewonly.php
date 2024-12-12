<?php

// for view only
// no seesion check is required, no login is required too.

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
    <h1>泊車管理系統(檢視)</h1>
    <p><?php echo APP_USER ; ?></p> 
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
              echo "<td>". $row['carno']."<br>".$row['cartype']."</td>";
              // echo "<td>". $row['cartype']. "</td>";
              echo "<td>". $strDate. "<br>". $strTime. "</td>";
              if ($stay_mintues > 30) {
                echo "<td><FONT COLOR=red>". $strMintue. "</FONT><br>";
              } else {
                echo "<td>". $strMintue. "<br>";
              }
              echo $row['code']. "</td>";
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
