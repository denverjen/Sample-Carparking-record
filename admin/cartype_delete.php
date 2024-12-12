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
  // select the cartypes from the table cartype
  $query = "SELECT * FROM cartype WHERE id = '$id'";
  $result = mysqli_query($conn, $query);
  $row = mysqli_fetch_assoc($result);
  $cartypes = $row['cartypes'];
  // handle post request
  if(isset($_POST['submit'])) {
    $id = $_POST['id'];
    // delete the cartypes from the table cartype
    $query = "DELETE FROM cartype WHERE id = '$id'";
    $result = mysqli_query($conn, $query);
    // redirect to the cartypes maintain page
    header('Location: cartype.php');
  }
?>
<html>
  <!-- include header.php -->
  <?php  include "header.php" ;?>
  <body>
    <div class="jumbotron text-center">
      <h1>刪除車輛類型</h1>
    </div>
    <div class="container">
      <div class="row">
        <div class="col-sm-12">
          <form action="cartype_delete.php" method="post">
            <div class="form-group">
              <label for="cartypes">車輛類型</label>
              <input type="text" class="form-control" id="cartypes" name="cartypes" value="<?php echo $cartypes;?>" readonly>
              <input type="hidden" name="id" value="<?php echo $id;?>">
              <input type="submit" class="btn btn-primary" name="submit" value="刪除">
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


