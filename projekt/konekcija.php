<?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $basename = "franceinfo_db";

    $dbc = mysqli_connect($servername, $username, $password, $basename) 
        or die("Error - došlo je do greške prilikom povezivanja na bazu podataka." .mysqli_error());

    mysqli_set_charset($dbc, "utf8");
?>