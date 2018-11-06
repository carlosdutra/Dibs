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
        $address = validateData($_POST['address']);
        $email = validateData($_POST['email']);
        $phone = validateData($_POST['phone']);
        $id = $_SESSION['loggedId'];
        

        //Check if email is valid
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errorMessage = "<div class='alert alert-danger'>Please provide valid e-mail!<a class='close' data-dismiss='alert'>&times;</a></div>";

        } else {
            //Check if phone is all numbers    
            if(!preg_match("/^[0-9]{3}-[0-9]{3}-[0-9]{4}$/", $phone)) {
                $errorMessage = "<div class='alert alert-danger'>Please check phone number! (E.g. 000-000-0000)<a class='close' data-dismiss='alert'>&times;</a></div>";
            } else {
                //Sql query
                $sql = "INSERT INTO clients (client_name, client_address, client_phone, client_email, user_id) VALUES ('$cname', '$address', '$phone', '$email', $id);";

                include('php_includes/dbh-inc.php');

                //Running the sql query into the database
                mysqli_query($conn, $sql);

                $errorMessage = "<div class='alert alert-success' >Client registered successfully!<a class='close' data-dismiss='alert'>&times;</a></div>";
                
            }
        }
    }

    /*if (isset($_POST['delete'])) {
        
        $clientID = $_GET['id'];
        
        $sql = "DELETE FROM clients WHERE id='$clientID'";
        mysqli_query($conn, $sql);
        header("Location: clients.php");
        
    }*/
        
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
                      <a class="btn btn-primary" data-toggle="collapse" href="#registerCollapse" role="button" aria-expanded="false" aria-controls="collapseExample">
                        Register new client
                      </a>
                    </p>
                    
                    <?php 
                        if (isset($errorMessage)){

                            echo $errorMessage; 
                        }
                    ?>
                    
                    <div class="collapse" id="registerCollapse">
                      <div class="card card-body">
                        <form action="#" method="POST" role="form">
                            <div class="form-group">
                                <input type="text" class="form-control" id="name" name="cname" placeholder="Corporation name" required>
                            </div>

                            <div class="form-group">
                                <input type="text" class="form-control" id="address" name="address" placeholder="Address" required>
                            </div>

                            <div class="form-group">
                                <input type="email" class="form-control" id="email" name="email" placeholder="E-mail" required>
                            </div>     

                            <div class="form-group">
                                <input type="text" class="form-control" id="phone" name="phone" placeholder="Phone" required>
                            </div>

                            <button type="submit" name="submit" class="btn btn-primary">Register</button>
                            <button type="reset" class="btn btn-danger" data-toggle="collapse" data-target="#registerCollapse" >Cancel</button>

                        </form>  
                      </div>
                    </div>
                    <br>
                    <table class="table table-striped table-dark">
                      <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Name</th>
                            <th scope="col">Adress</th>
                            <th scope="col">Phone</th>
                            <th scope="col">E-mail</th>
                            <th scope="col">
                            <!--<form class="form-inline my-2 my-lg-0">
                              <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
                              <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
                            </form>-->
                            </th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                        include('php_includes/dbh-inc.php');
                        
                        $id = $_SESSION['loggedId'];
                          
                        //Sql Query
                        $sql = "SELECT * FROM clients WHERE user_id='$id'";

                        //Store the result
                        $result = mysqli_query($conn, $sql);
                        $i = 0;
                          
                        while($row = mysqli_fetch_assoc($result)) {
                            $i++;
                            echo "<tr><td>{$i}</td><td>{$row['client_name']}</td><td>{$row['client_address']}</td><td>{$row['client_phone']}</td><td>{$row['client_email']}</td>
                            
                            <td>
                                <a href='edit-client.php?id={$row['id']}'><button type='button' class='btn btn-primary btn-sm'>Edit</button></a>
                            </td>
                            
                            
                            </tr>
                            ";
                        }
                                       
                        ?>
                      </tbody>
                    </table>
                    
                    <nav aria-label="Page navigation example">
                      <ul class="pagination">
                        <li class="page-item">
                          <a class="page-link" href="#" aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
                            <span class="sr-only">Previous</span>
                          </a>
                        </li>
                        <li class="page-item"><a class="page-link" href="#">1</a></li>
                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                        <li class="page-item">
                          <a class="page-link" href="#" aria-label="Next">
                            <span aria-hidden="true">&raquo;</span>
                            <span class="sr-only">Next</span>
                          </a>
                        </li>
                      </ul>
                    </nav>
                                        
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
