<!DOCTYPE HTML>
<html>
    <head>
        <title>Franceinfo - administracija</title>
	    <meta charset="UTF-8"/>
        <meta name="author" content="Vlatka Korbar">
        <meta name="description" content="Projektni zadatak - Francuska novinarska stranica">
        <link rel="icon" href="slike/franceinfo-logo.png" type="image/png">
        <link rel="stylesheet" type="text/css" href="stilovi/stil_administracija.css">
        <script src="https://kit.fontawesome.com/b05e340512.js" crossorigin="anonymous"></script>
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
                    <a class="nav_buttons" name="administracija">administracija</a>
                </div>
            </nav>

            <main class="content_container">
                <?php 
                    session_start();

                    include 'konekcija.php';

                    if(isset($_SESSION['ulogirani_user_uloga'])){
                        if($_SESSION['ulogirani_user_uloga']==1){
                            echo "
                                <a id='unos_gumb' href='unos.php?id=0'>Dodaj članak <i class='fa-solid fa-circle-plus' id='unos_ikona'></i></a>
                                <table id='tablica_clanaka'>
                                    <tr id='head_redak'>
                                        <th>Naslov članka</th>
                                        <th>Datum objave</th>
                                        <th id='arhiva_cell'>Arhivirano</th>
                                        <th colspan='2'>Opcije</th>
                                    </tr>
                            ";
    
                            $select_query = "SELECT * FROM clanak ORDER BY datum DESC";
                            $result = mysqli_query($dbc, $select_query);
                            while($row = mysqli_fetch_array($result)){
                                $arhiva_vrijednost="Ne";
                                if($row['arhivirano']==1){
                                    $arhiva_vrijednost="Da";
                                }
                                echo "
                                    <tr>
                                        <td id='naslov_cell'><div>".$row['naslov']."</div></td>
                                        <td id='datum_cell'>".date("d.m.Y.",strtotime($row['datum']))."</td>
                                        <td>".$arhiva_vrijednost."</td>
                                        <td>
                                            <a id='update_gumb' class='gumb' href='unos.php?id=".$row['id']."'>Uredi</a>
                                        </td>
                                        <td>
                                            <form method='POST' action=''>
                                                <input type='hidden' value='".$row['id']."' name='id'>
                                                <input type='submit' name='delete' id='delete_gumb' class='gumb' value='Obriši'>
                                            </form>
                                        </td>
                                    </tr>
                                ";
                            }
                            
                            echo "
                            </table>
                            ";
    
                            if(isset($_POST['delete'])){
                                $id = $_POST['id'];
    
                                $delete_query = "DELETE FROM clanak WHERE id = $id;";
    
                                $result = mysqli_query($dbc, $delete_query) 
                                or die("Error - pogreška u unošenju podataka u bazu podataka" .mysqli_error());
    
                                echo "<meta http-equiv='refresh' content='0'>";
                            }
                        }
                        else{
                            echo "<div id='poruka'><p>".$_SESSION['ulogirani_user_username']." - Nemate pravo pristupa ovoj stranici.</p></div>";
                        }
                    }
                    else{
                        echo "<div id='poruka'><p>Nise ulogirani u korisnički račun - Nemate pravo pristupa ovoj stranici.</p></div>";
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