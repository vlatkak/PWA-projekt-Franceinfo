<!DOCTYPE HTML>
<html>
    <head>
        <title>Franceinfo</title>
	    <meta charset="UTF-8"/>
        <meta name="author" content="Vlatka Korbar">
        <meta name="description" content="Projektni zadatak - Francuska novinarska stranica">
        <link rel="icon" href="slike/franceinfo-logo.png" type="image/png">
        <link rel="stylesheet" type="text/css" href="stilovi/stil_index.css">
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
                    $kategorija = $_GET['kategorija'];
                    $select_query = "SELECT * FROM clanak WHERE kategorija = '".$kategorija."' ORDER BY datum DESC;";

                    $result = mysqli_query($dbc, $select_query);
                    
                    if($result){
                        echo "<h2>".ucfirst($kategorija)."</h2>";
                        $br=0;
                        while($br==0){
                            echo "<section>";
                            
                            for($i=0; $i<4; $i++){
                                $row = mysqli_fetch_array($result);
                                if(!$row){
                                    $br=1;
                                    break;
                                }
                                if($row['arhivirano']==0){
                                    echo"
                                        <a class='article_link' href='clanak.php?id=".$row['id']."'>
                                            <article>
                                                <img src='slike/".$row['slika']."' id='placeholder_image' alt='image' class='article_image'>
                                                <p class='article_title'>".$row['naslov']."</p>
                                            </article>
                                        </a>
                                    ";
                                }
                            }

                            echo "</section>";
                        }
                    }

                    mysqli_close($dbc);
                ?>
            </main> 

            <footer>
                <div class="content_container">
                    <p>Vlatka Korbar | vkorbar@tvz.hr | 2024</p>
                </div>
            </footer>
        </div>
    </body>
</html>