<?php
    session_start();
    if(isset($_SESSION["username"])=="" ||isset($_SESSION["email"])=="")
    {
        header("location:login.php");
    }
    else{
        include("connection.php");
        $getUserQuery="select * from tbluser where username='$_SESSION[username]'";
        $getUser=mysqli_query($connection,$getUserQuery);
        $userInfo=mysqli_fetch_assoc($getUser);
        $reminderListQuery="select * from tblNotes where userID='$userInfo[userID]' order by noteDate desc";
        if($reminderList=mysqli_query($connection,$reminderListQuery)){

        }
        if(isset($_POST["btnAddNote"]))
        {
            $noteName=$_POST["noteName"];
            $noteDate=$_POST["noteDate"];
            $noteCont=$_POST["noteCont"];
            echo "$noteName $noteCont";
            if($noteName=="" || $noteCont=="")
            {
                echo "<div class='alert alert-primary' role='alert'>
                You need to fill name and content fields 
                </div>";
            }
            else {
                
                    if(mysqli_num_rows($getUser)<=0)
                    {
                    echo "<div class='alert alert-danger' role='alert'>
                    Unexpected error couldn't get your user informations please logout and login again.
                    </div>";
                    }
                    else{
                        $insertQuery="insert into tblnotes(noteName,noteContent,noteDate,userID) values ('$noteName','$noteCont','$noteDate','$userInfo[userID]')";
                        $add=mysqli_query($connection,$insertQuery);
                        if($add)
                        {
                            echo "<div class='alert alert-success' role='alert'>
                            Reminder Added Successfully
                        </div>";
                        header("location:index.php");
                        }
                        else{
                            echo "<div class='alert alert-danger' role='alert'>
                            Unexpected Error please try again
                        </div>";
                        }
                    }
                }
        }
            if(isset($_POST["btnDelete"])){
                $deleteQuery="delete from tblnotes where noteID=$_POST[btnDelete]";
                $delete=mysqli_query($connection,$deleteQuery);
                if($delete)
                {
                    header("location:index.php");
                }
                else{
                    echo "<div class='alert alert-danger' role='alert'>
                    Unexpected Error please try again
                </div>";
                }
               
            }
}
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Homepage</title>
    <script src="https://kit.fontawesome.com/65e6e42703.js" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        .exitButton{
            padding:0
        }
        .exitButton a{
            color:#dc3545; 
            text-decoration: none;
            transition:250ms all;
            padding: 0.375rem 0.75rem ;
        }
        .exitButton:hover a{
            color:white
        }
    </style>
</head>
  <body>
    <nav class="navbar bg-dark " data-bs-theme="dark"> 
    <div class="container">
        <a class="navbar-brand">
            <?php
                echo $_SESSION["username"];
            ?>
        </a>
        <button class="btn btn-outline-danger exitButton" ><a href="login.php" style="display:block">Exit</a></button>
    </div>
    </nav>
    <div class="container pt-5">
        <h3>Create New Reminder</h3>
        <div class="card p-5 mt-5">
            <form action="index.php" method="POST">
                <div class="mb-3">
                    <label  class="form-label">Name</label>
                    <input type="text" class="form-control" name="noteName">
                </div>
                <div class="mb-3">
                    <label  class="form-label">Note Content</label>
                    <input type="text" class="form-control" name="noteCont">
                </div>
                <div class="mb-3">
                    <label  class="form-label">Date</label>
                    <input type="date" class="form-control" name="noteDate">
                </div>
                <button type="submit" class="btn btn-primary" name="btnAddNote">Add</button>
            </form>
        </div>
    </div>
    <div class="container mt-4">
            <table class="table">
        <thead>
            <tr>
            <th scope="col">Reminder Date</th>
            <th scope="col">Note Name</th>
            <th scope="col">Note Content</th>
            <th scope="col">Delete</th>
            </tr>
        </thead>
        <tbody>
           
               <?php
                while($row=mysqli_fetch_assoc($reminderList))
                {
                    ?>
                    <tr>
                    <td><?php echo $row['noteDate'] ?></td>
                    <td><?php echo $row['noteName'] ?></td>
                    <td><?php echo $row['noteContent'] ?></td>
                    <td>
                        <form method="POST">
                        <?php
                            echo "
                            <button type='submit' class='btn btn-danger' name='btnDelete' value=$row[noteID]><i class='fa-solid fa-trash'></i></button>
                            "
                        ?>
                        </form>
                    </td>
                    </tr>
                    <?php
                }
                ?>            
            <tr>
        </tbody>
        </table>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  </body>
</html>