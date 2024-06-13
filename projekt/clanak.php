<!DOCTYPE HTML>
    <html>
    <head>
        <title>Franceinfo</title>
	    <meta charset="UTF-8"/>
        <meta name="author" content="Vlatka Korbar">
        <meta name="description" content="Projektni zadatak - Francuska novinarska stranica">
        <link rel="icon" href="slike/franceinfo-logo.png" type="image/png">
        <link rel="stylesheet" type="text/css" href="stilovi/stil_clanak.css">
        <style>
            .article_image{
                width: 100%;
            }
        </style>
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

            <main>

                <?php 
                    include 'konekcija.php';

                    $id = $_GET['id'];
                    
                    $select_query = "SELECT * FROM clanak WHERE id=$id";
                    $result = mysqli_query($dbc, $select_query); 
                    $row = mysqli_fetch_array($result);
                    
                    echo "
                    <h1 class='article_title'>".$row['naslov']."</h1>
                    <p id='sazetak'>".$row['sazetak']."</p>
                    <img class='article_image' src='slike/".$row['slika']."'></img>
                    <p>".$row['tekst']."</p>
                    ";

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