<?php

    if(isset($_POST["submit"])){
        $datum = $_POST["datum"];
        $kategorija = $_POST["kategorija"];
        $naslov = mysqli_real_escape_string($dbc, $_POST["naslov"]);
        $sazetak = mysqli_real_escape_string($dbc, $_POST["sazetak"]);
        $tekst = mysqli_real_escape_string($dbc, $_POST["tekst"]);
        $putanjaSlike = $_FILES["slika"]["name"];
        $imeSlike = $_FILES["slika"]["tmp_name"];
        if(isset($_POST["arhiva"])){
            $arhiva = 1;
        }
        else{
            $arhiva="";
        }

        $direktorij = "slike/".$putanjaSlike; 
        move_uploaded_file($imeSlike, $direktorij);

        $query = "INSERT INTO clanak (arhivirano, kategorija, naslov, datum, sazetak, tekst, slika)
            VALUES('$arhiva', '$kategorija', '$naslov', '$datum', '$sazetak', '$tekst', '$putanjaSlike');";
        
        if($id!=0){
            $query = "UPDATE clanak SET arhivirano = '$arhiva', kategorija='$kategorija', naslov='$naslov',
            datum='$datum', sazetak='$sazetak', tekst='$tekst', slika='$putanjaSlike' WHERE id=$id;";
        }
        
        $result = mysqli_query($dbc, $query) or die("Error - pogreška u unošenju podataka u bazu podataka" .mysqli_error());
    }
?>