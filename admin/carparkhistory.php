<?php
  // start php session
  session_start();
  // check if user is logged in
  if(!isset($_SESSION['uname'])){
    header('Location: login.php');
  }
  // include dbconfig.php
  include_once("../include/dbconfig.php");
  // list the carparking records with pagination for 8 records per page
  $page = $_GET['page'];
  if(!isset($page)){
    $page = 1;
  }
  $start = ($page-1)*8;
  $query = "SELECT *,TIMESTAMPDIFF(SECOND, time_in, NOW()) as time_stay FROM carparking where parking = 0 order by time_in desc LIMIT $start,8";
  $result = mysqli_query($conn, $query);
  $rows = mysqli_num_rows($result);
  // get the total number of records or 500 records
  $query = "SELECT COUNT(*) FROM carparking where parking = 0";
  $result = mysqli_query($conn, $query);
  $row = mysqli_fetch_assoc($result);
  $total_records = $row['COUNT(*)'];
  // maximum number of records is 500
  if($total_records > 500){
    $total_records = 500;
  }
  // get the total number of pages
  $total_pages = ceil($total_records/8);
  // get the previous page
  if($page > 1){
    $prev_page = $page-1;
  }else{
    $prev_page = 1;
  }
  // get the next page
  if($page < $total_pages){
    $next_page = $page+1;
  } else{
    $next_page = $total_pages;
  }
  // get the carparking records with give page
  $query = "SELECT *,TIMESTAMPDIFF(SECOND, time_in, time_out) / 60 as time_stay ". 
           "FROM carparking where parking = 0 order by time_in desc LIMIT $start,8";
  $carparkresult = mysqli_query($conn, $query);
  $rows = mysqli_num_rows($carparkresult);


?>
<html>
  <!-- include header.php -->
  <?php include "header.php" ; ?>
  <style>

  #td100 {
      width: 100px;
  }

  #td200 {
      width: 200px;
  }
  </style>
  <body>
    <div class="jumbotron text-center">
      <h1>泊車紀錄</h1>
      <p><?php echo APP_USER.'('.$total_records.')' ; ?></p>
    </div>
    <div class="container" style="width:900px;">
            <table class="table table-striped table-bordered table-hover" width="900px">
              <thead>
                <tr>
                  <td id="td100">車牌</td>
                  <td id="td100">車輛類型</td>
                  <td id="td100">入車時間</td>
                  <td id="td100">離開時間</td>
                  <td id="td100">停泊時間</td>
                  <td id="td100">原因</td>
                  <td id="td100">座/室</td>
                </tr>
              </thead>
              <tbody>
                <?php
                while($rows = mysqli_fetch_assoc($carparkresult)) {
                  echo "<tr>";
                  echo "<td>". $rows['carno']. "</td>";
                  echo "<td>". $rows['cartype']. "</td>";
                  echo "<td>". $rows['time_in']. "</td>";
                  echo "<td>". $rows['time_out']. "</td>";
                  echo "<td>". round( $rows['time_stay'] ). "分鐘</td>";
                  echo "<td>". $rows['code']. "</td>";
                  echo "<td>". $rows['blk']. $rows['room']. "</td>";
                  echo "</tr>";
                }
                ?>
                </tbody>
              </table>
              <div class="text-center">
                <ul class="pagination">
                  <li><a href="carparkhistory.php?page=<?php echo $prev_page ;?>">&laquo;</a></li>
                  <?php for($i=1;$i<=$total_pages;$i++){?>
                    <li><a href="carparkhistory.php?page=<?php echo $i ;?>"><?php echo $i ;?></a></li>
                    <?php }?>
                    <li><a href="carparkhistory.php?page=<?php echo $next_page ;?>">&raquo;</a></li>
                </ul>
              </div>
              <a href="index.php" class="btn btn-primary">返回</a>
            </div>
    <!-- include footer.php -->
    <?php include "footer.php" ; ?>
  </body>
</html>
      
        



          



