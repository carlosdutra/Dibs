<?php
    
    session_start();

    if (!isset($_SESSION['loggedUser'])) {
        $notLogged = true;
    }
    
    $billId = $_GET['billid'];
    $clientID = $_SESSION['loggedId'];
    
    include('php_includes/dbh-inc.php');

    $sql = "SELECT * FROM bills WHERE user_id_bill='$clientID'";
    $result = mysqli_query($conn, $sql);
    
    if ( mysqli_num_rows($result) > 0 ) {
        
        while($row = mysqli_fetch_assoc($result)) {
            $pname            = $row['bill_payee'];
            $amount           = $row['bill_amount'];
            $descr            = $row['bill_desc'];
        }
        
        
    } else {
        $alertMessage = "<div class='alert alert-danger' >No data found.<a class='close' data-dismiss='alert'>&times;</a></div>";
    }

    //UPDATE
    if (isset($_POST['update'])) {
    
        //Prevent PHP Injection    
        function validateData( $data ) {
            $data = trim(stripslashes(htmlspecialchars($data)));
            return $data;
        }

        //Wrap data with the function
        //$pname = validateData($_POST['cname']);
        $amount = validateData($_POST['amount']);
        $descr = validateData($_POST['description']);

        //Sql query
        $sql = "UPDATE bills 
        SET bill_amount  = '$amount',
            bill_desc    = '$descr'
        WHERE
            bill_id='$billId'";

        //Running the sql query into the database
        mysqli_query($conn, $sql);

        $alertMessage = "<div class='alert alert-success' >Updated client successfully!<a class='close' data-dismiss='alert'>&times;</a></div>";
    }
    

    if (isset($_POST['delete'])) {
        
        $sql = "DELETE FROM bills WHERE id='$clientID'";
        mysqli_query($conn, $sql);
        header("Location: bills.php");
        
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
                            <div class='input-group mb-3'>
                                <div class='input-group-prepend'>
                                    <label class='input-group-text' for='inputGroupSelect01'>Client</label>
                                </div>
                                
                                <select class='custom-select' name="cname" id='inputGroupSelect01'>
                                  <?php

                                    //Getting user ID
                                    $id = $_SESSION['loggedId'];

                                    include('php_includes/dbh-inc.php');
                                    $billId = $_GET['billid'];
                                    
                                    //Sql Query
                                    $sql = "SELECT bill_payee FROM bills WHERE bill_id='$billId'";

                                    //Store the result
                                    $result = mysqli_query($conn, $sql);

                                    if (mysqli_num_rows($result) > 0) {

                                    while($row = mysqli_fetch_assoc($result)) {
                                    ?>

                                    <option value="<?php echo $row['bill_payee'];?>" selected><?php echo $row['bill_payee'];?></option>

                                    <?php } } ?>                                      
                                </select>
                                
                            </div>
                            
                            <div class="form-group">
                             <div class="input-group">
                                 <div class="input-group-prepend">
                                    <span class="input-group-text">$</span>
                                  </div>
                                <input type="text" class="form-control" id="amount" name="amount" value="<?php echo $amount ?>" required>
                            </div>
                            </div>

                            <div class="form-group">
                                <textarea class="form-control" id="description" name="description" required><?php echo $descr ?></textarea>
                            </div>

                            <button type="submit" name="update" class="btn btn-primary">Update</button>
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
