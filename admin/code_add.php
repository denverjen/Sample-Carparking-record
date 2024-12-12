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
  // Table codes :
  // CREATE TABLE IF NOT EXISTS codes (
  //  id int(11) NOT NULL AUTO_INCREMENT,
  //  codename varchar(50) NOT NULL,
  //  PRIMARY KEY ( id )
  // );
  
  // handle form submit
  if(isset($_POST['submit'])) {
    $codename = $_POST['codename'];
    $query = "INSERT INTO codes (codename) VALUES ('$codename')";
    $result = mysqli_query($conn, $query);
    if($result) {
      echo "<script>alert('新增成功');</script>";
    } else {
      echo "<script>alert('新增失敗');</script>";
    }
    Header('Location: codemaintain.php');
  }
?>
<html>
  <!-- include header.php -->
  <?php  include "header.php" ;?>
  <body>
    <div class="jumbotron text-center">
      <h1>新增原因</h1>
    </div>
    <div class="container">
      <div class="row">
        <div class="col-sm-12">
          <form action="code_add.php" method="post">
            <div class="form-group">
              <label for="codename">原因</label>
              <input type="text" class="form-control" id="codename" name="codename" placeholder="請輸入原因">
              <input type="submit" class="btn btn-primary" name="submit" value="新增">
              <a href="code.php" class="btn btn-primary">取消</a>
            </div>
          </form>
        </div>
      </div>
    </div>
    <!-- include footer.php -->
    <?php  include "footer.php" ;?>
  </body>
</html>
