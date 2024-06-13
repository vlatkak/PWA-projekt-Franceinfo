<!DOCTYPE HTML>
<html>
    <head>
        <title>Franceinfo - login</title>
	    <meta charset="UTF-8"/>
        <meta name="author" content="Vlatka Korbar">
        <meta name="description" content="Projektni zadatak - Francuska novinarska stranica">
        <link rel="icon" href="slike/franceinfo-logo.png" type="image/png">
        <link rel="stylesheet" type="text/css" href="stilovi/stil_registracija.css">
    </head>
    <body>
        <div id="sve">
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

            <main>
                <h1>Kreirajte novi račun</h1>
                <form action="" method="POST">
                    <label>Ime:</label>
                    <input class="text_inputs" type="text" name="ime" id="ime" required>
                    <label id="ime_poruka"></label>
                    <label>Prezime:</label>
                    <input class="text_inputs" type="text" name="prezime" id="prezime" required>
                    <label id="prezime_poruka"></label>
                    <label>Korisničko ime:</label>
                    <input class="text_inputs" type="text" name="username" id="username" required>
                    <label id="username_poruka"></label>
                    <label>Lozinka:</label>
                    <input class="text_inputs" type="text" name="pass1" id="pass" required>
                    <label>Ponovno unesite lozinku:</label>
                    <input class="text_inputs" type="text" name="pass2" id="pass2" required>
                    <label id="pass2_poruka"></label>
                    <input id="kreiraj_gumb" type="submit" name="submit" value="Kreiraj račun">
                </form>

                <script>
                    document.getElementById("kreiraj_gumb").onclick = function(event) {
                            var validno = true;

                            var imeOkvir = document.getElementById('ime');
                            var ime = document.getElementById('ime').value;
                            if(ime.length > 32){
                                validno = false;
                                document.getElementById("ime_poruka").innerHTML = "<label style='color: red'>Ime ne smije biti duže od 32 znaka.</label>";
                                imeOkvir.style.border = "1px red solid";
                            }

                            var prezimeOkvir = document.getElementById('prezime');
                            var prezime = document.getElementById('prezime').value;
                            if(ime.length > 32){
                                validno = false;
                                document.getElementById("prezime_poruka").innerHTML = "<label style='color: red'>Prezime ne smije biti duže od 32 znaka.</label>";
                                prezimeOkvir.style.border = "1px red solid";
                            }

                            var usernameOkvir = document.getElementById('username');
                            var username = document.getElementById('username').value;
                            if(username.length > 32){
                                validno = false;
                                document.getElementById("username_poruka").innerHTML = "<label style='color: red'>Korisničko ime ne smije biti duže od 32 znaka.</label>";
                                usernameOkvir.style.border = "1px red solid";
                            }

                            var pass = document.getElementById('pass').value;
                            var pass2 = document.getElementById('pass2').value;

                            if(pass !== pass2){
                                validno=false;
                                document.getElementById("pass2_poruka").innerHTML = "<label style='color: red'>Unesene dvije lozinke nisu identične.</label>";
                            }

                            if (validno == false) {
                                event.preventDefault();
                            }
                        }
                </script>

                <?php 
                    include 'konekcija.php';

                    if(isset($_POST['submit'])){
                        $ime = $_POST["ime"];
                        $prezime = $_POST["prezime"];
                        $username = $_POST["username"];
                        $pass1 = $_POST["pass1"];
                        $pass2 = $_POST["pass2"];

                        $lozinka =  password_hash($pass1, CRYPT_BLOWFISH);

                        $select_query = "SELECT * FROM korisnik WHERE username = ?;";

                        $stmt=mysqli_stmt_init($dbc);

                        if(mysqli_stmt_prepare($stmt, $select_query)){
                            mysqli_stmt_bind_param($stmt, 's', $username);
                            mysqli_stmt_execute($stmt);
                            mysqli_stmt_store_result($stmt);
                        }

                        if(mysqli_stmt_fetch($stmt)==null){
                            $insert_query = "INSERT INTO korisnik (ime, prezime, username, lozinka)
                            VALUES(?, ?, ?, ?);";
    
                            $stmt = mysqli_stmt_init($dbc);
    
                            if(mysqli_stmt_prepare($stmt, $insert_query)){
                                mysqli_stmt_bind_param($stmt, 'ssss', $ime, $prezime, $username, $lozinka);
                                mysqli_stmt_execute($stmt);
                            }
    
                            echo "<script> location.href='login.php'; </script>";
                            exit;
                        }
                        else{
                            echo "<p style='font-style: italic'>Uneseno korisničko ime je već u uporabi. Molimo unesite novo.</p>";
                        }

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