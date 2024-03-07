<?php
include("connection.php");
session_start();
$_SESSION=array();
session_destroy();
if(isset($_POST["btnLogin"]))
{
    $name=$_POST["username"];
    $password=$_POST["password"];
    if($name=="" || $password=="")
    {
        echo "<div class='alert alert-primary' role='alert'>
        Please fill in all fields
          </div>";
    }
    else {
        $CheckLoginQuery="select * from tbluser where username='$name' and password='$password'";
        $checkLogin=mysqli_query($connection,$CheckLoginQuery);
        if(mysqli_num_rows($checkLogin)<=0)
        {
          echo "<div class='alert alert-danger' role='alert'>
          Incorrect username or password
        </div>";
        }
        else{
            echo "<div class='alert alert-success' role='alert'>
                    Login Successful
                  </div>";
                  $userInfo=mysqli_fetch_assoc($checkLogin);
                  session_start();
                  $_SESSION["username"]=$userInfo["username"];
                  $_SESSION["email"]=$userInfo["usermail"];
                  header("location:index.php");
        }
    }
}
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>
    <style>
      .registerLink a{
        text-decoration:none;
        color:#878787;
        transition:250ms all;
        border-radius:5px;
        padding:5px 10px
      }
      .registerLink a:hover{
        color:white;
        background-color:#878787;
      }
    </style>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  </head>
  <body>
    <div class="container pt-5">
        <div class="card p-5 mt-5">
            <form action="login.php" method="POST">
                <div class="mb-3">
                    <label class="form-label">Username</label>
                    <input type="text" class="form-control" name="username">
                </div>
                <div class="mb-3">
                    <label  class="form-label">Password</label>
                    <input type="password" class="form-control" name="password">
                </div>
                <button type="submit" class="btn btn-primary" name="btnLogin">Login</button>
                <h6 class="text-end registerLink mt-3"><a href="register.php">Create your account</a></h6>
            </form>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  </body>
</html>