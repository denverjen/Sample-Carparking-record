<?php
  // start php session
  session_start();
  // check if user is logged in
  if(!isset($_SESSION['uname'])){
    header('Location: login.php');
  }
  // include dbconfig.php
  include_once("include/dbconfig.php");
  // get the id
  $id = $_GET['id'];
  // echo "id = ".$id."<br>";
  // update the carparking record from the database
  // set parking to 0, time_out to NOW()
  $query = "UPDATE carparking SET parking = 0, time_out = NOW() WHERE id = $id";
  $result = mysqli_query($conn, $query);
  // redirect to index.php
  header('Location: index.php');
?>
