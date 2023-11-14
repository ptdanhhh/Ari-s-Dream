<?php
  session_start();
  require_once 'dbconnect.php';
  if( isset($_POST['signup']) && $_POST["username"] != '' && $_POST["password"] != ''){ // sign up section

    $username = $_POST['username'];
    $sql = "SELECT * FROM user_info WHERE user_name='$username'";
    $isAvailable = mysqli_query($conn,$sql);

    if (mysqli_num_rows($isAvailable) > 0){

      echo "Username available please try again";

    } else {

      $username = $_POST['username'];
      $password = $_POST['password'];
      $salt1 = "e#fna$%#2";
      $salt2 = "243rwe890";

      $newPassword = md5($salt1 . $password . $salt2); // encrypted password

      $sql = "INSERT INTO user_info (user_name, hashed_password) VALUES ('$username', '$newPassword')";
      $query = mysqli_query($conn,$sql);
      
      if($query){ 
        echo"<script>alert('Account Registered Successfully')</script>";
        echo "<script>window.location.href='/Ari-s-Dream/form/login.html';</script>";
      } 
    }
  }

  if( isset($_POST['login']) && $_POST["username"] != '' && $_POST["password"] != ''){ // login section
    $username = $_POST['username'];
    $password = $_POST['password'];
    $salt1 = "e#fna$%#2";
    $salt2 = "243rwe890";
    $password = md5($salt1 . $password . $salt2); // encrypted password

    $sql = "SELECT * FROM user_info WHERE user_name='$username' AND hashed_password='$password'";
    $Credentials = mysqli_query($conn,$sql);

    if (mysqli_num_rows($Credentials) > 0){ // check if query return 1 row mean username and pw are correct
      $_SESSION["user"] = $username;
      header("location:home.php");
    } else {
      echo"username or password was wrong";
    }
  }
?>



