<?php
  // delete the user from the table users
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
  // get the user id from the url
  $id = $_GET['id'];
  // select the user from the table users
  $query = "SELECT * FROM users WHERE id = '$id'";
  $result = mysqli_query($conn, $query);
  $row = mysqli_fetch_assoc($result);
  $name = $row['name'];
  // handle post request
  if(isset($_POST['submit'])) {
    $id = $_POST['id'];
    // delete the user from the table users
    $query = "DELETE FROM users WHERE id = '$id'";
    $result = mysqli_query($conn, $query);
    // redirect to the user maintain page
    header('Location: usermaintain.php');
  }

?>

<html>
  <!-- include header.php -->
  <?php  include "header.php" ; ?>
  <body>
    <div class="jumbotron text-center">
    <h1>刪除用戶</h1>
    <!--　display the user name and ask for confirmation -->
    <form action="user_delete.php" method="post">
      <div class="form-group">
        <label for="name">用戶名稱:</label>
        <input type="text" class="form-control" id="name" name="name" value="<?php echo $name;?>" readonly>
        <input type="hidden" name="id" value="<?php echo $id;?>">
        <input type="submit" class="btn btn-primary" name="submit" value="刪除">
        <a href="usermaintain.php" class="btn btn-primary">取消</a>
      </div>
    </form>
    </div>
    <!-- include footer.php -->
    <?php  include "footer.php" ; ?>
  </body>
</html>
