<?php
    $dbhost = 'localhost:3306';  
    $dbuser = 'root';
    $dbpass = '';
    $dbname = 'bankingsystem';

    $conn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
    if(! $conn ) {
        die('Could not connect: ' . mysqli_connect_error());
    }
?>