<?php

if (isset($_POST['submit'])) {
    
    //Prevent PHP Injection    
    function validateData( $data ) {
        $data = trim(stripslashes(htmlspecialchars($data)));
        return $data;
    }
    
    //Wrap data with the function
    $username = validateData($_POST['username']);
    $password = validateData($_POST['password']);
    
    //Connect to the Database
    include('php_includes/dbh-inc.php');
    
    //Sql Query
    $sql = "SELECT * FROM users WHERE user_uid='$username'";//"SELECT * FROM users WHERE user_uid='' OR 1=1 SEL";
    
    //Store the result
    $result = mysqli_query($conn, $sql);
    
    //Verify if result is returned    
    if (mysqli_num_rows($result) > 0) {
        
        while($row = mysqli_fetch_assoc($result)) {
            $id               = $row['user_id'];
            $first            = $row['user_first'];
            $last             = $row['user_last'];
            $user             = $row['user_uid'];
            $email            = $row['user_email'];
            $hashedPassword   = $row['user_pwd'];
        }
        
        if ( password_verify($password, $hashedPassword)) {
            
            //Corerct Login statements!
            //Start the session!
            session_start();
            
            //Store data session variables
            $_SESSION['loggedId'] = $id;
            $_SESSION['loggedFirst'] = $first;
            $_SESSION['loggedLast'] = $last;
            $_SESSION['loggedUser'] = $user;
            $_SESSION['loggedEmail'] = $email;
            
            header("Location: profile.php");
            
            
        } else {

            $error = "<div class='alert alert-danger'>Login/Password incorrect! Please try again.<a class='close' data-dismiss='alert'>&times;</a></div>";    
            
        }
        
    } else {
        

        $error = "<div class='alert alert-danger'>Username/E-mail does not exist.<a class='close' data-dismiss='alert'>&times;</a></div>";    
        
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="style/stylesheet.css" type="text/css">
    <title>Dibs</title>

</head>

<body>
    <div class="vertical-center">
        <div class="container theme-showcase" role="main">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <form action="#" method="POST" role="form">
                        <legend>Login</legend>

                        <div class="form-group">
                            <input type="text" class="form-control" id="username" name="username" placeholder="Username/E-mail">
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-control" id="password" name="password" placeholder="Password">
                        </div>

                        <button type="submit" name="submit" class="btn btn-primary">Login</button>
                    </form>

                        <br>
                        
                        <!--Message PHP-->
                        <?php

                            if (isset($error)) {
                                echo $error;
                            }

                        ?>

                        <a class="btn btn-default" href="register.php">Sign up</a><br>
                        <a class="btn btn-default" href="#">Forgot password?</a>

                </div>
            </div>
        </div>
    </div>
    

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
</body>
</html>
