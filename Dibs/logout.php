<?php

    if(isset($_COOKIE[session_name()])) {
        
        setcookie(session_name(), '', time()-86400, '/');
        
    }

    session_unset();
    
    //session_destroy();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="style/stylesheet.css" type="text/css">
    <title>Logged out</title>
</head>

<body>
    <div class="vertical-center">
        <div class="container">
            <div class="row">
                <div class="centerCol col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <h2>You've been logged out!</h2><a href='index.php'>Go back to home page</a>
                </div>
            </div>
        </div>
    </div>
    
    

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.5/js/bootstrap.min.js"></script>


</body>
</html>
