<?php
    
    session_start();

    if (!isset($_SESSION['loggedUser'])) {
        $notLogged = true;
    }

    if (isset($_POST['submit'])) {
    
        //Prevent PHP Injection    
        function validateData( $data ) {
            $data = trim(stripslashes(htmlspecialchars($data)));
            return $data;
        }

        //Wrap data with the function
        $cname = validateData($_POST['cname']);
        $amount = validateData($_POST['amount']);
        $description = validateData($_POST['description']);
        $id = $_SESSION['loggedId'];

        //Check if email is valid
        $sql = "INSERT INTO bills (bill_payee, bill_amount, bill_desc, user_id_bill) VALUES ('$cname', '$amount', '$description', '$id');";

        include('php_includes/dbh-inc.php');

        //Running the sql query into the database
        mysqli_query($conn, $sql);

        $errorMessage = "<div class='alert alert-success' >Bill registered successfully!<a class='close' data-dismiss='alert'>&times;</a></div>";
        
        }
        
    if (isset($_POST['paid'])) {

        $id = $_SESSION['loggedId'];
        $sql = "UPDATE bills SET paid = '1' WHERE user_id_bill = '$id'";
        include('php_includes/dbh-inc.php');
        mysqli_query($conn, $sql);

    }

    if (isset($_POST['edit'])) {
        
        $billID = $_GET['billid'];
        $sql = "DELETE FROM bills WHERE bill_id='$billId'";
        mysqli_query($conn, $sql);
        $alertMessage = "<div class='alert alert-success' >Bill deleted successfully!<a class='close' data-dismiss='alert'>&times;</a></div>";
        
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
                    
                    <p>
                      <a class="btn btn-primary" data-toggle="collapse" href="#registerCollapse" role="button" aria-expanded="false" aria-controls="collapseExample">Register new bill</a>
                        <a class="btn btn-danger" href="bills.php" role="button">Pending bills</a>
                        <a class="btn btn-success" href="paid-bills.php" role="button">Paid bills</a>
                    </p>
                    
                    <div class="collapse" id="registerCollapse">
                      <div class="card card-body">
                        <form action="#" method="POST" role="form">
                            <div class='input-group mb-3'>
                                  <div class='input-group-prepend'>
                                    <label class='input-group-text' for='inputGroupSelect01'>Client</label>
                                  </div>
                                  <select class='custom-select' name="cname" id='inputGroupSelect01'>
                                  <option selected>Choose...</option>
                                  <?php
                                      
                                    //Getting user ID
                                    $id = $_SESSION['loggedId'];

                                    include('php_includes/dbh-inc.php');
                                    //Sql Query
                                    $sql = "SELECT client_name FROM clients WHERE user_id='$id'";

                                    //Store the result
                                    $result = mysqli_query($conn, $sql);

                                    if (mysqli_num_rows($result) > 0) {

                                    while($row = mysqli_fetch_assoc($result)) {
                                    ?>
                                      
                                    <option value="<?php echo $row['client_name'];?>"><?php echo $row['client_name'];?></option>

                                    <?php } } ?>                                    
                                </select>
                            </div>
                            
                            <div class="form-group">
                             <div class="input-group">
                                 <div class="input-group-prepend">
                                    <span class="input-group-text">$</span>
                                  </div>
                                <input type="text" class="form-control" id="amount" name="amount" placeholder="Amount" required>
                            </div>
                            </div>

                            <div class="form-group">
                                <textarea class="form-control" id="description" name="description" placeholder="Service description..." required></textarea>
                            </div>

                            <button type="submit" name="submit" class="btn btn-primary">Register</button>
                            <button type="reset" class="btn btn-danger" data-toggle="collapse" data-target="#registerCollapse" >Cancel</button>
                            
                        </form>  
                      </div>
                    </div>                   
                    <br>
                    <?php
                    
                        $id = $_SESSION['loggedId'];
                    
                        //Sql Query
                        //$sql = "SELECT * FROM bills WHERE user_id_bill='$id'";

                        include('php_includes/dbh-inc.php');

                        //Running the sql query into the database
                        //$result = mysqli_query($conn, $sql);
                    
                        //Check if there's a bill paid
                        $sql1 = "SELECT * FROM `bills` WHERE `paid` = 1 AND `user_id_bill` = $id";
                        
                        $result1 = mysqli_query($conn, $sql1);
                        echo "<small>Total of bills mark as paid: ".mysqli_num_rows($result1)."</small>";
                        //echo mysqli_num_rows($result1);
                    
                        if (mysqli_num_rows($result1) > 0) {
                            
                            //Show all pending bills
                            $sql = "SELECT * FROM bills WHERE `paid` = 1 AND user_id_bill='$id'";
                            $result = mysqli_query($conn, $sql);
                            
                             while ($row = mysqli_fetch_assoc($result)) {
                                $billId = $row['bill_id'];
                                $name   = $row['bill_payee'];
                                $amount = $row['bill_amount'];
                                $descr  = $row['bill_desc'];

                                 echo "

                                    <div class='card'>
                                      <div class='card-header'>$name</div>
                                      <div class='card-body'>
                                        <h5 class='card-title'>$$amount</h5>
                                        <p class='card-text'>$descr</p>
                                        <form action='#' method='POST' role='form'>
                                        <button type='submit' name='paid' class='btn btn-success' disabled>Paid</button>
                                        <a href='edit-bill.php?billid=$billId'><button type='button' name='edit' class='btn btn-primary'>Edit</button></a>
                                        </form>
                                      </div>
                                    </div><br>                            

                                ";

                                    /*echo "

                                        <div class='alert alert-warning' role='alert'>
                                          No pending bills found!
                                        </div>

                                    ";*/
                                }
                            
                        } else {
                            
                            echo "

                                        <div class='alert alert-warning' role='alert'>
                                          No paid bills found!
                                        </div>

                                    ";
                            
                        }
                         
                    
                        
                    
                    ?>
                                        
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