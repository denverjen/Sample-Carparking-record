<?php
  // start php session
  session_start();
  // check if user is logged in
  if(!isset($_SESSION['uname'])) {
    header('Location: login.php');
  }
  // check if user is an admin
  if($_SESSION['utype']!= 'admin') {
    header('Location: login.php');
  }
  // table cartype : 
  //CREATE TABLE IF NOT EXISTS `cartype` (
  //  `id` int(11) NOT NULL AUTO_INCREMENT,
  //  `cartypes` varchar(50) NOT NULL,
  //  PRIMARY KEY (`id`)
  //);
  
  // include dbconfig.php
  include_once("../include/dbconfig.php");
  $query = "SELECT * FROM cartype order by cartypes";
  $result = mysqli_query($conn, $query);
  $rows = mysqli_num_rows($result);
?>
<html> 
  <!-- include header.php -->
  <?php  include "header.php" ;?>
  <body>
    <div class="jumbotron text-center">
      <h1>車輛類型</h1>
    <div>
    <a href="cartype_add.php" class="btn btn-primary">新增車輛類型</a>
    <a href="index.php" class="btn btn-primary">返回</a>
    </div>
    <table class="table table-hover">
      <thead>
        <tr>
          <th>車輛類型</th>
          <th>操作</th>
        </tr>
      </thead>
      <tbody>
        <?php
        while($row = mysqli_fetch_assoc($result)) {
          echo "<tr>";
          echo "<td>". $row['cartypes']. "</td>";
          echo "<td><a href='cartype_delete.php?id=". $row['id']. "' class='btn btn-danger'>刪除</a></td>";
          echo "</tr>";
        }
        ?>
      </tbody>
    </table>
    </div>
    <?php include "footer.php" ;?>
  </body>
</html>

