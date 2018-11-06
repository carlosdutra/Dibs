<?php
    
    session_start();

    if (!isset($_SESSION['loggedUser'])) {
        $notLogged = true;
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
                    <h2><?php if (isset($_SESSION['loggedFirst']) && isset($_SESSION['loggedLast'])) { echo "Welcome ".$_SESSION['loggedFirst']." ".$_SESSION['loggedLast']."!"; } ?></h2>
                    <h3><?php if (isset($_SESSION['loggedUser'])) { echo "Username: ".$_SESSION['loggedUser']; } ?></h3>
                    <h3><?php if (isset($_SESSION['loggedEmail'])) { echo "E-mail: ".$_SESSION['loggedEmail']."<br>" ; } ?></h3>
                    <br>
                                        
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
