<?php
  session_start();
  require_once 'dbconnect.php';

  if( isset($_POST['signup']) && $_POST["username"] != '' && $_POST["password"] != ''){ // sign up section

    $username = $_POST['username'];

    $sql = "SELECT * FROM user_info WHERE user_name=?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 's', $username);
    mysqli_stmt_execute($stmt);
    $isAvailable = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($isAvailable) > 0){

      echo "Username available please try again";

    } else {

      function generateRandomSalt($length = 16) {
        return bin2hex(random_bytes($length));
      }

      $username = $_POST['username'];
      $password = $_POST['password'];

      $salt = generateRandomSalt();
      $newPassword = md5($salt . $password); // encrypted password

      $sql = "INSERT INTO user_info (user_name, hashed_password, salt) VALUES (?, ?, ?)";
      $stmt = mysqli_prepare($conn, $sql);
      mysqli_stmt_bind_param($stmt, 'sss', $username, $newPassword, $salt);
      $query = mysqli_stmt_execute($stmt);
      
      if($query){ 
        echo"<script>alert('Account Registered Successfully')</script>";
        echo "<script>window.location.href='/Ari-s-Dream/form/login.html';</script>";
      } 
    }
  }

  if( isset($_POST['login']) && $_POST["username"] != '' && $_POST["password"] != ''){ // login section
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM user_info WHERE user_name=?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 's', $username);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($result)) {
      // Combine the retrieved salt with the entered password and hash
      $saltedPassword = md5($row['salt'] . $password);

      // Check if the calculated hash matches the stored hashed password
      if ($saltedPassword === $row['hashed_password']) {
        $_SESSION["user"] = $username;
        header("location:home.php");
      } else {
        echo "Username or password was wrong";
      }

    } else {
      echo "Username or password was wrong";
    }
  }
?>



