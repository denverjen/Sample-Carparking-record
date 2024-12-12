<?php
  // clear php session
  session_destroy() ;
  // start php session
  session_start();
  // unset session variables
  unset($_SESSION['uname']);
  // include dbconfig.php
  include_once("include/dbconfig.php");

  // handle login post request
  if(isset($_POST['submit'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $query = "SELECT * FROM users WHERE name = '$username' AND password = '$password'";
    $result = mysqli_query($conn, $query);
    $rows = mysqli_num_rows($result);
    $errmsg = "" ;
    if($rows == 1) {
      $row = mysqli_fetch_assoc($result);
      $_SESSION['uname'] = $username;
      Header( 'Location: index.php');
    } else {
      $errmsg = "用戶名稱及密碼不符" ;
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
              <?php echo $errmsg ; ?>
            </p>
            <form action="login.php" method="POST">
              <div class="form-group">
                <label for="username">用戶名稱:</label>
                <input type="text" class="form-control" id="username" name="username" placeholder="Enter username">
                <label for="password">用戶密碼:</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Enter password">
                <input type="submit" name="submit" value="提交" class="btn btn-primary">
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
