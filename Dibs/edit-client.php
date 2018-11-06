<?php
    
    session_start();

    if (!isset($_SESSION['loggedUser'])) {
        $notLogged = true;
    }
    
    $clientID = $_GET['id'];
    
    include('php_includes/dbh-inc.php');

    $sql = "SELECT * FROM clients WHERE id='$clientID'";
    $result = mysqli_query($conn, $sql);
    
    if ( mysqli_num_rows($result) > 0 ) {
        
        while($row = mysqli_fetch_assoc($result)) {
            $cname            = $row['client_name'];
            $address          = $row['client_address'];
            $phone            = $row['client_phone'];
            $email            = $row['client_email'];            
        }
        
        
    } else {
        $alertMessage = "<div class='alert alert-danger' >No data found<a class='close' data-dismiss='alert'>&times;</a></div>";
    }

    //UPDATE
    if (isset($_POST['update'])) {
    
        //Prevent PHP Injection    
        function validateData( $data ) {
            $data = trim(stripslashes(htmlspecialchars($data)));
            return $data;
        }

        //Wrap data with the function
        $cname = validateData($_POST['cname']);
        $address = validateData($_POST['address']);
        $email = validateData($_POST['email']);
        $phone = validateData($_POST['phone']);

        //Check if email is valid
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $alertMessage = "<div class='alert alert-danger'>Please provide valid e-mail!<a class='close' data-dismiss='alert'>&times;</a></div>";

        } else {
            //Check if phone is all numbers    
            if(!preg_match("/^[0-9]{3}-[0-9]{3}-[0-9]{4}$/", $phone)) {
                $alertMessage = "<div class='alert alert-danger'>Please check phone number! (E.g. 000-000-0000)<a class='close' data-dismiss='alert'>&times;</a></div>";
            } else {
                //Sql query
                $sql = "UPDATE clients 
                SET client_name = '$cname',                    
                    client_address = '$address',
                    client_phone = '$phone',
                    client_email = '$email'
                WHERE
                    id='$clientID'";

                //Running the sql query into the database
                mysqli_query($conn, $sql);

                $alertMessage = "<div class='alert alert-success' >Updated client successfully!<a class='close' data-dismiss='alert'>&times;</a></div>";
            }
        }
    }

    if (isset($_POST['delete'])) {
        
        $sql = "DELETE FROM clients WHERE id='$clientID'";
        mysqli_query($conn, $sql);
        header("Location: clients.php");
        
    }
        
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="style/stylesheet.css" type="text/css">
    <title>Profile - <?php echo $_SESSION['loggedUser']; ?></title>

</head>

<body>
    <?php include('navbar.php'); ?>

    <div class="notVerticallyCentered">
        <div class="container">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <?php 
                        if (isset($alertMessage)){

                            echo $alertMessage; 
                        }
                    ?>                    
                    
                      <div class="card card-body">
                        <form action="#" method="POST" role="form">
                            <div class="form-group">
                                <input type="text" class="form-control" id="name" name="cname" placeholder="Corporation name" value="<?php echo $cname ?>" required>
                            </div>

                            <div class="form-group">
                                <input type="text" class="form-control" id="address" name="address" placeholder="Address" value="<?php echo $address ?>" required>
                            </div>

                            <div class="form-group">
                                <input type="email" class="form-control" id="email" name="email" placeholder="E-mail" value="<?php echo $email ?>" required>
                            </div>     

                            <div class="form-group">
                                <input type="text" class="form-control" id="phone" name="phone" placeholder="Phone" value="<?php echo $phone ?>" required>
                            </div>

                            <button type="submit" name="update" class="btn btn-primary">Update</button>
                            <a href="clients.php" class="btn btn-danger">Cancel</a>
                            <button type="submit" name="delete" class="btn btn-danger float-right">Delete</button>

                        </form>  
                      </div>
                    
                    
                                        
                    <?php include('php_includes/not-logged.php');?>                    
                </div>
            </div>
        </div>   
    </div>
    
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
</body>
</html>
