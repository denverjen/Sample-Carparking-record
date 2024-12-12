<?php 
// CREATE TABLE admins (
// id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
//  auser VARCHAR(255) NOT NULL,
//   apassword VARCHAR(255) NOT NULL,
//  UNIQUE INDEX auser_index (auser) );
// insert into admins ( auser, apassword ) values ( 'tycuser','abpassowrd') ;
// clear the session
session_destroy();
// start php session
session_start();
// include dbconfig.php
include_once("../include/dbconfig.php");
// check if the form is submitted

if(isset($_POST['submit'])) {
  // get the form data
    $username = $_POST['username'];
    $password = $_POST['password'];
    // check if the user exists in the database
    $query = "SELECT * FROM admins WHERE auser = '$username' AND apassword = '$password'";
    // echo $query ;
    $result = mysqli_query($conn, $query);
    $rows = mysqli_num_rows($result);

    $errmsg = '' ;
    if($rows == 1) {
      // if the user exists, then create a session
      $_SESSION['uname'] = $username;
      $_SESSION['utype'] = 'admin';
      // redirect to the admin page
      header('Location: index.php');
    } else {
      // if the user does not exist, then redirect to the login page
      $errmsg = '管理員名稱或密碼錯誤' ;
    }
  } 
?>

<html>
  <?php include_once("header.php");?>
  <body>
  <?php include_once("topbar.php");?>
  <!-- create the login form -->
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-4">
        <div class="card">
          <div class="card-header">
            <a href="login.php"><h4>登入</h4></a>
            <p class="text-danger">
              <?php
              echo $errmsg ;
              ?>
              </p>
            <form method="POST" action="login.php">
              <div class="form-group">
                <label for="username">管理員名稱:</label>
                <input type="text" class="form-control" id="username" name="username" placeholder="Enter username">
                <label for="password">管理員密碼:</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Enter password">
                <input type="submit" class="btn btn-primary" name="submit" value="sumbit">
              </div>
            </form>
          </div>
        </div>
      </div>
    <!-- end login form -->
    </div>
  </div>
  <?php include "footer.php";?>
  </body>
</html>
