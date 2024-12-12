<?php
  // start the session
  session_start();
  // check if user is logged in
  if(!isset($_SESSION['uname'])){
    header('Location: login.php');
  }
  // include dbconfig.php
  include_once("include/dbconfig.php");
?>

<!-- display a form for enduser to select a date range for reporting -->
<html>
  <?php include "header.php" ; ?>
  <body>
    <div class="jumbotron text-center">
      <h1><?php echo APP_NAME ; ?></h1>
      <p><?php echo APP_USER ; ?></p>
    </div>
    <div class="container">
      <div class="row">
        <div class="col-sm-12">
          <!-- date range form -->
          <form action="printdailyreport.php" method="post">
            <div class="form-group">
              <label for="date_from">開始日期</label>
              <!-- set default value to last day -->
              <input type="date" class="form-control" id="date_from" name="date_from" value="<?php echo date("Y-m-d", strtotime("-1 day"));?>" required>
              <label for="date_to">結束日期</label>
              <!-- set default value to last day  -->
              <input type="date" class="form-control" id="date_to" name="date_to" value="<?php echo date("Y-m-d", strtotime("-1 day"));?>" required>
              <input type="submit" class="btn btn-primary" value="查詢">
              <a href="index.php" class="btn btn-primary">返回</a>
            </div>
          </form>
        </div>
      </div>
    </div>
    <!-- include footer.php -->
    <?php include "footer.php" ; ?>
  </body>
</html>

    
