<?php require_once 'dbconnect.php'; 
 session_start();
 $username = $_SESSION["user"];
?>

<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1, shrink-to-fit=no"
    />
    <!-- Bootstrap CSS Start -->
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css"
      integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N"
      crossorigin="anonymous"
    />
    <!-- Bootstrap CSS End -->
    <!-- Import font Start-->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;1,400&display=swap"
      rel="stylesheet"
    />
    <!-- Import font End-->
    <link rel="stylesheet" href="/Ari-s-Dream/css/style.css" />
    <title>Welcome to Ari Dream</title>
  </head>
  <body>
    
    <a href="/Ari-s-Dream/home.php" class="btn btn-primary mt-3 ml-3 mb-3">Home</a>
    
    
    <div class="table-responsive">
      <table class="table table-hover table-bordered">

        <tr class="table-success">
          <th scope="col" class="text-center" style="border: 2px solid">
            Text
          </th>
          <th scope="col" class="text-center" style="border: 2px solid">
            Image
          </th>
        </tr>
        <?php
          $query = "SELECT * FROM user_data WHERE user='$username' ORDER BY id DESC";
          $rows = $conn->query($query); 
        ?>
        <?php foreach($rows as $row): ?>
          <tr>
            <td style="border: 2px solid">
              <?php echo $row["text_input"];?>
            </td>

            <td style="border: 2px solid">
              <img src="picture/<?php echo $row["image_file"];?>" width = 200>
            </td>
          </tr>
        <?php endforeach; ?>
        
      </table>
    </div>
  </body>
</html>
