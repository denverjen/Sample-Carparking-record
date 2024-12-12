<?php
  // start php session
  session_start();
  // check if user is logged in
  if(!isset($_SESSION['uname'])){
    header('Location: login.php');
  }
  // include dbconfig.php
  include_once("include/dbconfig.php");
  // table carparking
  // CREATE TABLE carparking (
  // id int(11)  NOT NULL AUTO_INCREMENT,
  // carno varchar(50) NOT NULL,
  // cartype varchar(50) NOT NULL,
  // time_in DATETIME,
  // time_out DATETIME,
  // code VARCHAR(50),
  // blk VARCHAR(50),
  // room VARCHAR(50),
  // parking INT DEFAULT 1 ,
  // overtime INT,
  // cphone VARCHAR(50),
  // PRIMARY KEY ( id ),
  // INDEX park_index (parking, id)
  // ) ;
  // get the cartypes
  $query = "SELECT * FROM cartype" ;
  $result = mysqli_query($conn, $query);
  $rows = mysqli_num_rows($result);
  // store the cartypes in an array
  $cartypes = array();
  while($row = mysqli_fetch_assoc($result)) {
    $cartypes[] = $row['cartypes'];
  }
  // get the codes
  $query = "SELECT * FROM codes";
  $result = mysqli_query($conn, $query);
  $rows = mysqli_num_rows($result);
  // store the codes in an array
  $codes = array();
  while($row = mysqli_fetch_assoc($result)) {
    $codes[] = $row['codename'];
  }
  // set the blocks array
  $blocks = array('A', 'B', 'C', 'D', 'E', '其他' ) ;

  // handle carparking post request
  if(isset($_POST['submit'])) {
    $carno = strtoupper( $_POST['carno'] );
    $cartype = $_POST['cartype'];
    $code = $_POST['code'];
    $blk = $_POST['blk'];
    $room = $_POST['room'];
    $cphone = $_POST['cphone'];
    // check if the carno is empty
    if(empty($carno)) {
      echo "<script>alert('車號不能為空');</script>";
      exit;
    }
    // check if the carno exsits and parking is 1
    $query = "SELECT * FROM carparking WHERE carno = '$carno' AND parking = 1" ;
    $result = mysqli_query($conn, $query);
    $rows = mysqli_num_rows($result);
    if($rows > 0) {
      echo "<script>alert('車號已存在');</script>";
      exit;
    }
    // insert the carparking record
    $query = "INSERT INTO carparking (carno, cartype, time_in, code, blk, room, cphone) VALUES ('$carno', '$cartype', NOW(), '$code', '$blk', '$room', '$cphone')" ;
    // $query = "INSERT INTO carparking ( carno, cartype ) VALUES ('$carno', '$cartype' ) ";
    // echo "<script>alert( $query ) ;</script>";
    $result = mysqli_query($conn, $query);
    // redirect to index.php
    if($result) {
      Header( "Location: index.php" ) ;
    }

    
  } 
?>
<!-- handle carparking post request -->
<html>
  <!-- include header.php -->
  <?php  include "header.php" ;  ?>
  <style>
    #name-input:valid { text-transform: uppercase; }
  </style>
  <body>
    <div class="jumbotron text-center">
      <h1><?php echo APP_NAME ; ?></h1>
      <p><?php echo APP_USER ; ?></p>
    </div>
    <div class="container">
      <div class="row">
        <div class="col-sm-12 center">
          <!-- carparking form -->
          <form action="carin.php" method="POST">
            <div class="form-group">
              <label for="carno">車牌</label>
              <!-- carno not empty -->
              <input type="text"   class="form-control" id="name-input" name="carno" placeholder="車牌" required>
              <label for="cartypes">車輛類型</label>
              <!-- select the cartypes -->
              <select class="form-control" id="cartype" name="cartype">
                <?php
                foreach($cartypes as $typename) {
                  echo "<option value='$typename'>$typename</option>";
                }
                ?>
              </select>
              <!-- select the codes -->
              <label for="code">原因</label>
              <select class="form-control" id="code" name="code">
                <?php
                foreach($codes as $code) {
                  echo "<option value='$code'>$code</option>";
                }
                ?>
              </select>
              <label for="blk">座</label>
              <select class="form-control" id="blk" name="blk">
                <?php
                foreach($blocks as $block) {
                  echo "<option value='$block'>$block</option>";
                }
                ?>
              </select>
              <label for="room">房</label>
              <input type="text" class="form-control" id="room" name="room" placeholder="房號" required>
              <label for="cphone">電話</label>
              <input type="text" class="form-control" id="cphone" name="cphone" placeholder="電話">
              <input type="submit" name="submit" value="提交" class="btn btn-primary">
              <a href="index.php" class="btn btn-primary">返回</a>


            </div>
          </form>
          <!-- end carparking form -->
        </div>
      </div>
    </div>
    <?php include_once("footer.php");?>
  </body>
</html>
          


