<?php
  // start php session
  session_start();
  // check if user is logged in
  if(!isset($_SESSION['uname'])){
    header('Location: login.php');
  }
  // check if user is an admin
  if($_SESSION['utype']!= 'admin') {
    header('Location: login.php');
  }
  // include dbconfig.php
  include_once("../include/dbconfig.php");
  
  $query = "SELECT *,TIMESTAMPDIFF(SECOND,  time_in, NOW()) as time_stay FROM carparking WHERE parking = 1 order by time_in desc";
  $result = mysqli_query($conn, $query);
  $rows = mysqli_num_rows($result);
?>
<html>
  <!-- include header.php -->
  <?php 
  include "header.php" ;
  ?>
  <body>
    <div class="jumbotron text-center">
      <h1><?php echo APP_NAME; ?></h1>
      <p><?php echo APP_USER; ?>(管理員)</p>
      <a href="usermaintain.php" class="btn btn-primary">管理用戶</a>
      <a href="cartype.php" class="btn btn-primary">車輛類型</a>
      <a href="codemaintain.php" class="btn btn-primary">原因</a>
      <a href="carparkhistory.php" class="btn btn-primary">泊車輛紀錄</a>
    </div>
    <!-- display the carparking records where parking = 1 -->
    <div class="container">
    <div class="row">
      <div class="col-sm-12 center">
        <!-- center the table content -->
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

              $strMintue = floor($row['time_stay']/60). "分鐘";
              echo "<tr>";
              echo "<td>". $row['carno']. "</td>";
              // echo "<td>". $row['cartype']. "</td>";
              echo "<td>". $strDate. "<br>". $strTime. "</td>";
              echo "<td>". $strMintue. "</td>";
              // echo "<td>". $row['code']. "</td>";
              echo "<td><br><a href='car_info.php?id=". $row['id']."' class='btn btn-danger'>資料</a>" ;
              echo "</td>" ;
              echo "</tr>";
            }
            ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <?php
  include "footer.php" ;
  ?>
  </body>
</html>
