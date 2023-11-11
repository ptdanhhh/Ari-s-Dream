<?php
  session_start();
  require_once 'dbconnect.php';

  if( !isset($_SESSION["user"])) {
    header("location:form/login.html"); 

  } elseif (isset($_SESSION["user"])) {
    $username = $_SESSION["user"];
    echo "<h4>Hi $username</h4>";

    if(isset($_POST["submit"])){ 

      $text = $_POST["input_text"];
      // $filename = $_FILES["file"]["name"];
      // $tmpName = $_FILES["file"]["tmp_name"];
      
      // $destinationFolder = $_SERVER['DOCUMENT_ROOT'] . "/picture/" . basename($filename);
      // echo $destinationFolder;
      
      if (isset($_FILES["file"])){ // check and get file data
        $file = $_FILES["file"];
        if ($file["error"] === UPLOAD_ERR_OK && $file["type"] === "image/jpeg") { 
      
          $filename = $_FILES["file"]["name"];
          $tmpName = $_FILES["file"]["tmp_name"];

          $destinationFolder = $_SERVER['DOCUMENT_ROOT'] . "/picture/";
          $newfilename = uniqid() . "-" . basename($filename); // Generate a unique filename

          $destinationPath = $destinationFolder . $newfilename;

          if (move_uploaded_file($tmpName, $destinationPath)) {
              echo "File uploaded successfully.";
          } else {
              echo "Error moving the file.";
          }
        }    
      }

      if (isset($_FILES["file"]) && $_POST["input_text"]){ // query
        $query = "INSERT INTO user_data (text_input, image_file) VALUES ('$text','$filename')";
        $result = $conn->query($query);
      } elseif (isset($_FILES["file"]) && $_POST["input_text"] == ''){
        $query = "INSERT INTO user_data (text_input, image_file) VALUES ('','$filename')";
        $result = $conn->query($query);
      } 
    }
  }
?>

<html lang="en">
  <head>
    <meta charset="UTF-8" />
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
    <title>Ari Dream</title>
  </head>
  <body>

    <form action="/Ari-s-Dream/logout.php" method="post">
      <button type="submit" name="logout" class="btn btn-primary">logout</button>
    </form>

    <form
      action="/Ari-s-Dream/home.php"
      method="post"
      enctype="multipart/form-data"
    >
      <div class="text-center mt-4">
        <h1><strong>Welcome to Ari Dream</strong></h1>
      </div>
      <div class="row justify-content-center mt-4">
        <div class="col-md-4">
          <div class="card">
            <h4 class="pt-3 text-center card-header">Input Form</h4>
            <div class="card-body">
              <form>
                <div class="mb-3">
                  <div>Upload image</div>
                  <input type="file" name="file" accept=".jpeg" />
                </div>
                <div class="mb-3">
                  <div>Text</div>
                  <textarea
                    name="input_text"
                    placeholder="Enter your text"
                    cols="40"
                    rows="5"
                  ></textarea>
                </div>
                <div class="mb-1">
                  <button type="submit" name="submit" class="btn btn-primary">
                    Submit
                  </button>
                </div>
                <button type="submit" name="showdata" class="btn btn-primary">
                  View your data
                </button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </form>
  </body>
</html>