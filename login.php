<?php
  session_start();
  require_once 'dbconnect.php';

  if( isset($_POST['signup']) && $_POST["username"] != '' && $_POST["password"] != ''){ // sign up section

    $username = $_POST['username'];

    $sql = "SELECT * FROM user_info WHERE user_name=?"; // query and placeholder with prepare function
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 's', $username);
    mysqli_stmt_execute($stmt);
    $isAvailable = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($isAvailable) > 0){ // check if username input available in db if true meaning return value

      echo "Username available please try again";

    } else {

      function generateRandomSalt($length = 16) { // function that generate random 16bytes string ~ 32 character
        return bin2hex(random_bytes($length));
      }

      $username = $_POST['username'];
      $password = $_POST['password'];

      $salt = generateRandomSalt(); // get random salt
      $newPassword = md5($salt . $password); // encrypted password

      $sql = "INSERT INTO user_info (user_name, hashed_password, salt) VALUES (?, ?, ?)"; // insert user data with unique salt
      $stmt = mysqli_prepare($conn, $sql); // prepare statement avoid injection
      mysqli_stmt_bind_param($stmt, 'sss', $username, $newPassword, $salt); // convert var to string with built in function
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

    $sql = "SELECT * FROM user_info WHERE user_name=?"; // query and placeholder with prepare function
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 's', $username);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt); // 

    if ($row = mysqli_fetch_assoc($result)) {
      // Combine the retrieved salt with the entered password and hash
      $saltedPassword = md5($row['salt'] . $password);

      // Check if the calculated hash matches the stored hashed password
      if ($saltedPassword === $row['hashed_password']) {
        $_SESSION["user"] = $username; // store session user name to display later in home.php and to get data
        header("location:home.php");
      } else {
        echo "Username or password was wrong";
      }

    } else {
      echo "Username or password was wrong";
    }
  }
?>



