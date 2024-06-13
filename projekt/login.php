<!DOCTYPE HTML>
<html>
    <head>
        <title>Franceinfo - login</title>
	    <meta charset="UTF-8"/>
        <meta name="author" content="Vlatka Korbar">
        <meta name="description" content="Projektni zadatak - Francuska novinarska stranica">
        <link rel="icon" href="slike/franceinfo-logo.png" type="image/png">
        <link rel="stylesheet" type="text/css" href="stilovi/stil_login.css">
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
                <h1>Unesite svoje korisničke podatke</h1>
                <form action="" method="POST">
                    <label>Korisničko ime:</label>
                    <input class="text_inputs" type="text" name="username" required>
                    <label>Lozinka:</label>
                    <input class="text_inputs" type="text" name="lozinka" required>
                    <input name="submit" id="login_gumb" type="submit" value="Log in">
                </form>
                <div>
                    <p>Nemate račun? <a id="registracija_link" href="registracija.php">Kreirajte ga ovdje.</a></p>
                </div>
            </main>

            <?php 
                include 'konekcija.php';

                if(isset($_POST['submit'])){
                    $username = $_POST['username'];
                    $lozinka = $_POST['lozinka'];

                    $select_query = "SELECT id, lozinka, uloga FROM korisnik WHERE
                    username = ?;";

                    $stmt=mysqli_stmt_init($dbc);

                    if(mysqli_stmt_prepare($stmt, $select_query)){
                        mysqli_stmt_bind_param($stmt, 's', $username);
                        mysqli_stmt_execute($stmt);
                        mysqli_stmt_store_result($stmt);
                    }

                    mysqli_stmt_bind_result($stmt, $id, $hashed_lozinka, $uloga);
                    mysqli_stmt_fetch($stmt);
            
                    if(password_verify($lozinka, $hashed_lozinka)){
                        session_start();
                        $_SESSION['ulogirani_user_id'] = $id;
                        $_SESSION['ulogirani_user_username'] = $username;
                        $_SESSION['ulogirani_user_uloga'] = $uloga;
                    }
                    else{
                        echo "<p id='poruka'>Uneseni podaci nisu važeći. Molimo ponovan unos.</p>";
                    }

                    mysqli_close($dbc);
                }
            ?>

            <footer>
                <div class="footer_container">
                    <img src="slike/franceinfo-title-white.png" id="logo_white" alt="logo">
                </div>
            </footer>
        </div>
    </body>
</html>