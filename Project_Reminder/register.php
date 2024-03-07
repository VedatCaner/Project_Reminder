<?php
include("connection.php");
session_start();
$_SESSION=array();
session_destroy();
if(isset($_POST["btnRegister"]))
{
    $name=$_POST["username"];
    $mail=$_POST["email"];
    $password=$_POST["password"];
    if($name=="" || $mail=="" || $password=="")
    {
        echo "<div class='alert alert-primary' role='alert'>
        Please fill in all fields
          </div>";
    }
    else {
        $CheckUsernameQuery="select username from tbluser where username='$name'";
        $checkName=mysqli_query($connection,$CheckUsernameQuery);
        if(mysqli_num_rows($checkName)>0)
        {
          echo "<div class='alert alert-danger' role='alert'>
          This username is already taken
        </div>";
        }
        else{
            $CheckUsermailQuery="select usermail from tbluser where usermail='$mail'";
            $checkMail=mysqli_query($connection,$CheckUsermailQuery);
            if(mysqli_num_rows($checkMail)>0)
            {
              echo "<div class='alert alert-danger' role='alert'>
              This email is already taken
            </div>";
            }
            else{
                $Insertquery="insert into tbluser(username,usermail,password) values ('$name','$mail','$password')";
                $add=mysqli_query($connection,$Insertquery);
                if($add)
                {
                    echo "<div class='alert alert-success' role='alert'>
                    Register Successful <a href='login.php'>click here to login</a>
                  </div>";
                }
                else{
                    echo "<div class='alert alert-danger' role='alert'>
                    Unexpected Error
                  </div>";
                }
            }
        }

    }

}
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
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
  </head>
  <body>
    <div class="container pt-5">
        <div class="card p-5 mt-5">
            <form action="register.php" method="POST">
                <div class="mb-3">
                    <label  class="form-label">Username</label>
                    <input type="text" class="form-control" name="username">
                </div>
                <div class="mb-3">
                    <label  class="form-label">Email address</label>
                    <input type="email" class="form-control" name="email">
                </div>
                <div class="mb-3">
                    <label  class="form-label">Password</label>
                    <input type="password" class="form-control" name="password">
                </div>
                <button type="submit" class="btn btn-primary" name="btnRegister">Register</button>
                <h6 class="text-end registerLink mt-3"><a href="login.php">Log in</a></h6>
            </form>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  </body>
</html>