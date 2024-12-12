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
  // Table Users
  // CREATE TABLE users (
  //  id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  //  name VARCHAR(255) NOT NULL,
  //  password VARCHAR(255) NOT NULL,
  //  UNIQUE INDEX name_index (name)
  // );
  
  // include dbconfig.php
  include_once("../include/dbconfig.php");
  $query = "SELECT * FROM users order by name";
  $result = mysqli_query($conn, $query);
  $rows = mysqli_num_rows($result);
?>

<html>
  <!-- include header.php -->
  <?php  include "header.php" ; ?>
  <body>
  <div class="jumbotron text-center">
    <h1>用戶管理</h1>
    <p>管理用戶</p>
    <a href="user_add.php" class="btn btn-primary">新增用戶</a>
    <a href="index.php" class="btn btn-primary">返回</a>
  </div>
  <div class="container">
    <div class="row">
      <div class="col-sm-12">
        <table class="table table-hover">
          <thead>
            <tr>
              <th>用戶名稱</th>
              <th>操作</th>
            </tr>
          </thead>
          <tbody>
            <?php
            while($row = mysqli_fetch_assoc($result)) {
              echo "<tr>";
              echo "<td>". $row['name']. "</td>";
              echo "<td><a href='user_delete.php?id=". $row['id']. "' class='btn btn-primary'>刪除</a></td>";
              echo "</tr>";
            }
            ?>
            </tbody>
        </table>
      </div>
    </div>
  </div>
  <?php include "footer.php";?>
  </body>
</html>
