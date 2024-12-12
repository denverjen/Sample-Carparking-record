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
  // include dbconfig.php
  include_once("../include/dbconfig.php");

  // table cartype : 
  //CREATE TABLE IF NOT EXISTS `cartype` (
  //  `id` int(11) NOT NULL AUTO_INCREMENT,
  //  `cartypes` varchar(50) NOT NULL,
  //  PRIMARY KEY (`id`)
  //);

  // handle form submit
  if(isset($_POST['submit'])) {
    $cartypes = $_POST['cartypes'];
    $query = "INSERT INTO cartype (cartypes) VALUES ('$cartypes')";
    $result = mysqli_query($conn, $query);
    if($result) {
      echo "<script>alert('新增成功');</script>";
    } else {
      echo "<script>alert('新增失敗');</script>";
    }
  }

?>
<html>
  <!-- include header.php -->
  <?php  include "header.php" ;?>
  <body>
    <div class="jumbotron text-center">
      <h1>新增車輛類型</h1>
    </div>
    <div class="container">
      <div class="row">
        <div class="col-sm-12">
          <form action="cartype_add.php" method="post">
            <div class="form-group">
              <label for="cartypes">車輛類型</label>
              <input type="text" class="form-control" id="cartypes" name="cartypes" placeholder="請輸入車輛類型">
              <input type="submit" class="btn btn-primary" name="submit" value="新增">  
              <a href="cartype.php" class="btn btn-primary">取消</a>
            </div>
          </form>
        </div>
      </div>
    </div>
    <!-- include footer.php -->
    <?php  include "footer.php" ;?>
  </body>
</html>

            

