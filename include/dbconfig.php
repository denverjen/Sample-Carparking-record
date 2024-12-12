<?php
  // mysql Database connection
  $dbhost = "localhost";
  $dbuser = "dbusername";
  $dbpassword = "dbuserpassowrd";
  $dbname = "carpark";
  $conn = mysqli_connect($dbhost, $dbuser, $dbpassword, $dbname);
  
  define( 'APP_FOOTER','東東閣 泊車管理系統' ) ;
  define( 'APP_USER','東東閣' ) ;
  define( 'APP_NAME','泊車管理系統' ) ;
?>
