<?php
    if (isset($notLogged) && $notLogged == true) {
            echo "<h2>You must be logged to access website content!</h2>";
            echo "<a href='index.php'>Go back to home page</a>";
        }
?>