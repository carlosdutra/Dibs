<?php

if (isset($_POST['submit'])) {
    
    include('php_includes/dbh-inc.php');
    
    $first = $_POST['first'];
    $last = $_POST['last'];
    $email = $_POST['email'];
    $uid = $_POST['uid'];
    $pwd = $_POST['pwd'];
        
    //Error handlers
    //Check for empty fields
    
    
        //Check if names are all letters
        if (!preg_match("/^[a-zA-z]*$/", $first) || !preg_match("/^[a-zA-z]*$/", $last)) {
            $errorMessage = "<div class='alert alert-danger' >Please check first name or last name! Only letters are accepted.<a class='close' data-dismiss='alert'>&times;</a></div>";
            //header("Location: register.php?signup=invalid");
            //exit();
        } else {
            //Check if email is valid
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errorMessage = "<div class='alert alert-danger'>Please provide valid e-mail!<a class='close' data-dismiss='alert'>&times;</a></div>";
                //header("Location: register.php?signup=email");
                //exit();
            }
            //Check if user exists already
            else {
                $sql = "SELECT * FROM users WHERE user_uid='$uid'";
                $result = mysqli_query($conn, $sql);
                $resultCheck = mysqli_num_rows($result);
                
                if ($resultCheck > 0) {
                    $errorMessage = "<div class='alert alert-danger' >Sorry user already taken! Please provide different username.<a class='close' data-dismiss='alert'>&times;</a></div>";
                    //header("Location: register.php?signup=usertaken");
                    //exit();
                    
                } else {
                    //Hassing the password
                    $hashedPwd = password_hash($pwd, PASSWORD_DEFAULT);
                    //Insert the user into the database
                    $sql = "INSERT INTO users (user_first, user_last, user_email, user_uid, user_pwd) VALUES ('$first', '$last', '$email', '$uid', '$hashedPwd');";
                    
                    mysqli_query($conn, $sql);
                    
                    $errorMessage = "<div class='alert alert-success' >Welcome to Dibs " .$first."! Your registration was completed succesfully! <a href='index.php'>Go to login page</a><a class='close' data-dismiss='alert'>&times;</a></div>";
                    //header("Location: register.php?signup=success");
                    //exit();                 
                }
            }
        }
} 

?>

<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="style/stylesheet.css" type="text/css">
    <title>Dibs - Sign up</title>

</head>
    <body>
        <div class="vertical-center">
            <div class="container">
                <div class="row">
                    <div class="col-12">

                        <?php 

                        if (isset($errorMessage)){

                            echo $errorMessage; 
                        }
                        ?>

                        <form action="#" method="POST" role="form">
                            <legend>Sign up</legend>
                            
                            <div class="form-group">
                                <input type="text" class="form-control" id="fname" name="first" placeholder="First name" required>
                            </div>

                            <div class="form-group">
                                <input type="text" class="form-control" id="lname" name="last" placeholder="Last name" required>
                            </div>

                            <div class="form-group">
                                <input type="email" class="form-control" id="email" name="email" placeholder="E-mail" required>
                            </div>     

                            <div class="form-group">
                                <input type="text" class="form-control" id="uid" name="uid" placeholder="Username" required>
                            </div>

                            <div class="form-group">
                                <input type="password" class="form-control" id="pwd" name="pwd" placeholder="Password" required>
                            </div> 

                            <br>

                            <button type="submit" name="submit" class="btn btn-primary">Sign me up!</button>
                            <a href="index.php"><button type="button" class="btn btn-primary">Cancel</button></a>

                            <!--<div class="alert alert-danger" id="dv1" role="alert">

                            </div>-->
                        </form>

                    </div>
                </div>
            </div>
        </div>


        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    </body>
</html>