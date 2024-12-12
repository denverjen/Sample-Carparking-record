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

  // handle post request
  if(isset($_POST['submit'])) {
    // get the form data
    $name = $_POST['name'];
    $password = $_POST['password'];
    $password2 = $_POST['password2'];
    // check if the user exists in the database
    $query = "SELECT * FROM users WHERE name = '$name'";
    $result = mysqli_query($conn, $query);
    $rows = mysqli_num_rows($result);
    if($rows == 1) {
      header('Location: usermaintain.php?error=用戶已存在');
    } else {
      // if the user does not exist, then check retry password
      if($password == $password2) {
        // insert the user into the database
        $query = "INSERT INTO users ( name , password ) VALUES ( '$name', '$password' )";
        $result = mysqli_query($conn, $query);
        header('Location: usermaintain.php');
      }
    }
  }
?>
<html>
  <?php include_once("header.php");?>
  <body>
    <div class="jumbotron text-center">
      <h1>新增用戶</h1>
    </div>
  <div class="container">
    <div class="row">
      <div class="col-sm-12">
        <?php
        if(isset($_GET['error'])) {
          echo '<p class="text-danger">'.$_GET['error'].'</p>';
        }
        ?>
        <form method="POST" action="user_add.php">
          <div class="form-group">
            <label>用戶名稱</label>
            <input type="text" class="form-control" name="name" placeholder="Enter username">
            <label>密碼</label>
            <input type="password" class="form-control" name="password" placeholder="Enter password">
            <label>確認密碼</label>
            <input type="password" class="form-control" name="password2" placeholder="Enter password">
            <input type="submit" class="btn btn-primary" name="submit" value="提交">
            <a href="usermaintain.php" class="btn btn-primary">返回</a>
          </div>
        </form>
      </div>
    </div>
  </div>
  <?php include "footer.php";?>
 </body>
</html>
