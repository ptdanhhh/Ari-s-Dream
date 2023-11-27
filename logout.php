<?php
    session_start();
    if(isset($_POST['logout'])) {
        session_unset();
        session_destroy();
        header("location:form/login.html");  // clear all current session and redirect to login page
    }
?>