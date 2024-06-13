<!DOCTYPE HTML>
<html>
    <head>
        <title>Franceinfo - unos</title>
	    <meta charset="UTF-8"/>
        <meta name="author" content="Vlatka Korbar">
        <meta name="description" content="Projektni zadatak - Francuska novinarska stranica">
        <link rel="icon" href="slike/franceinfo-logo.png" type="image/png">
        <link rel="stylesheet" type="text/css" href="stilovi/stil_unos.css">
    </head>

    <body>
        <div id="sve">
            <div id="login_div"><a id="login_gumb" href="login.php">Log in</a></div>
            <header>
                <div class="content_container">
                    <img src="slike/franceinfo-title.png" id="logo" alt="logo">
                </div>
            </header>

            <nav>
                <div class="nav_container">
                    <a class="nav_buttons" name="home" href="index.php">home</a>
                    <a class="nav_buttons" name="elections" href="kategorija.php?kategorija=elections">elections</a>
                    <a class="nav_buttons" name="les jt" href="kategorija.php?kategorija=les jt">les jt</a>
                    <a class="nav_buttons" name="administracija" href="administracija.php">administracija</a>
                </div>
            </nav>

            <main class="content_container">
                    <?php
                        include "konekcija.php";

                        $id = $_GET['id'];

                        if($id==0){
                            echo "<h1>Unos novog članka</h1>";
                            $default_datum="";
                            $elections="selected";
                            $les_jt="";
                            $default_naslov="";
                            $default_sazetak="";
                            $default_tekst="";
                            $default_slika="";
                        }
                        else{
                            $select_query = "SELECT * FROM clanak WHERE id=$id";
                            $result = mysqli_query($dbc, $select_query); 
                            $row = mysqli_fetch_array($result);
                            echo "<h1>Izmjena članka</h1>";
                            $default_datum=$row['datum'];
                            if(strcmp($row['kategorija'], "elections")==0){
                                $elections="selected";
                                $les_jt="";
                            }
                            else{
                                $elections="";
                                $les_jt="selected";
                            }
                            $default_naslov=$row['naslov'];
                            $default_sazetak=$row['sazetak'];
                            $default_tekst=$row['tekst'];
                            $default_slika=$row['slika'];
                        }

                        echo "
                            <form id='input_form' action='' method='POST' enctype='multipart/form-data'>
                                <label class='form_labels'>Datum:</label>
                                <input type='date' id='date_picker' name='datum' value='".$default_datum."'/>
                                <br/>
                                <label class='form_labels'>Kategorija:</label>
                                <select name='kategorija' form='input_form'>
                                    <option ".$elections.">elections</option>
                                    <option ".$les_jt.">les jt</option>
                                </select>
                                <br/>
                                <label class='form_labels' id='naslov_label'>Naslov:</label>
                                <input type='text' class='text_inputs' id='naslov' name='naslov' value='".$default_naslov."'/>
                                <label id='naslov_alert'></label>
                                <br/>
                                <label class='form_labels'>Sažetak članka:</label>
                                <textarea form='input_form' class='text_inputs' rows='2' name='sazetak' id='sazetak'>".$default_sazetak."</textarea>
                                <label id='sazetak_alert'></label>
                                <br/>
                                <label>Tekst članka:</label>
                                <textarea form='input_form' id='text_input' rows='8' name='tekst'>".$default_tekst."</textarea>
                                <label id='tekst_alert'></label>
                                <br/>
                                <label class='form_labels' id='img_picker_label'>Slika:</label>
                                <input type='file' id='img_picker' name='slika'/>
                                <label id='slika_alert'></label>
                                <br/>
                                <label class='form_labels'><input type='checkbox' name='arhiva'/> Arhiviraj</label>
                                <br/>
                                <div id='submit_div'>
                                    <input type='submit' id='submit_gumb' value='Unesi članak' name='submit'/>
                                </div>
                            </form>
                        ";

                    ?>

                    <script type="text/javascript">
                        document.getElementById("submit_gumb").onclick = function(event) {
                            var validno = true;

                            var naslovOkvir = document.getElementById('naslov');
                            var naslov = document.getElementById('naslov').value;
                            if(naslov.length < 5 || naslov.length > 30){
                                validno = false;
                                document.getElementById("naslov_alert").innerHTML = "<label style='color: red'>Mora biti duljine 5-30 znakova!</label>";
                                naslovOkvir.style.border = "1px red solid";
                            }

                            var sazetakOkvir = document.getElementById('sazetak');
                            var sazetak = document.getElementById('sazetak').value;
                            if(sazetak.length < 10 || sazetak.length > 100){
                                validno = false;
                                document.getElementById("sazetak_alert").innerHTML = "<label style='color: red'>Mora biti duljine 10-100 znakova!</label>";
                                sazetakOkvir.style.border = "1px red solid";
                            }

                            var tekstOkvir = document.getElementById('text_input');
                            var tekst = document.getElementById('text_input').value;
                            if(tekst.length==0){
                                validno = false;
                                document.getElementById("tekst_alert").innerHTML = "<label style='color: red'>Polje ne smije biti prazno!</label>";
                                tekstOkvir.style.border = "1px red solid";
                            }

                            var slika = document.getElementById('img_picker').value;
                            if(slika.length==0){
                                validno = false;
                                document.getElementById("slika_alert").innerHTML = "<label style='color: red'>Slika mora biti odabrana!</label>";
                            }

                            if (validno == false) {
                                event.preventDefault();
                            }
                        }
                    </script>

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

                        mysqli_close($dbc);
                    ?>
            </main>

            <footer>
                <div class="footer_container">
                <img src="slike/franceinfo-title-white.png" id="logo_white" alt="logo">
                </div>
            </footer>

        </div>

    </body>
</html>