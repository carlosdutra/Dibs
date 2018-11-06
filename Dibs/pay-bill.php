<?php
    
    session_start();

    if (!isset($_SESSION['loggedUser'])) {
        $notLogged = true;
    }
    
    $billId = $_GET['billid'];
    $clientID = $_SESSION['loggedId'];    
    
    $sql = "SELECT * FROM bills WHERE bill_id='$billId'";

    include('php_includes/dbh-inc.php');
    $result = mysqli_query($conn, $sql);
    
    if ( mysqli_num_rows($result) > 0 ) {
        
        while($row = mysqli_fetch_assoc($result)) {
            $pname            = $row['bill_payee'];
            $amount           = $row['bill_amount'];
            $descr            = $row['bill_desc'];
        }
    }

    if (isset($_POST['yes'])) {

        $sql = "UPDATE bills SET paid = '1' WHERE bill_id = '$billId'";
        include('php_includes/dbh-inc.php');
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
                        
                        <form action="#" method="POST" role="form">
                            <h3>Do you want mark as paid <?php echo $pname ?> bill?</h3>
                            <a><button class="btn btn-success" name="yes">Yes</button></a>
                            <a href="bills.php" class="btn btn-danger">No</a>                            
                        </form>  
                                        
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