<div id='page-wrap'>
<header class='main' id='h1'>
    <?php
    $parametroak = "";
    if (isset($_GET['eposta'])) {
        $parametroak = "?eposta=".$_GET['eposta'];
        $parametroak = $parametroak."&irudia=".$_GET['irudia'];
    }

    if (isset($_SESSION['eposta'])) {
        echo '<span class="right"><a href="LogOut.php">Logout</a></span> &nbsp;';
        echo $_SESSION['eposta'].'&nbsp;';

        if (isset($_SESSION['irudia']) && file_exists($_SESSION['irudia'])) {
            $irudia = file_get_contents($_SESSION['irudia']);
            echo '<img src="data:image/*;base64,' . base64_encode($irudia) . '" height=50 width=50"/>';
        } else {
            echo '<img src="../images/default_erabiltzailea.png" height=50 width=50"/>';
        }
    } else {
        echo '<span class="right"><a href="SignUp.php">Erregistratu</a></span> &nbsp;';
        echo '<span class="right"><a href="LogIn.php">Login</a></span> &nbsp;';
        echo '<span class="right"><a href="PasahitzaBerreskuratu.php"> Pasahitza ahaztu zait </a></span> &nbsp;';
        /*echo '<script src="https://apis.google.com/js/platform.js" async defer></script>';
        echo '<meta name="google-signin-client_id" content="1006802611046-rh58g3scanp5kv5kq6u1h94jjp9ig10g.apps.googleusercontent.com">';
        echo '<div class="g-signin2" data-onsuccess="onSignIn"></div>';*/
        echo 'Anonimoa &nbsp;';
        echo '<img src="../images/erabiltzaile_anonimoa.png" height=50 width=50"/>';
    }
    ?>
</header>

<nav class='main' id='n1' role='navigation'>
    <?php
    if (isset($_GET['eposta'])) {
        $parametroak = "?eposta=".$_GET['eposta'];
        $parametroak = $parametroak."&irudia=".$_GET['irudia'];
        $parametroak = $parametroak."&rola=".$_GET['rola'];
    }

    echo '<span><a href="Layout.php">Hasiera</a></span>';
    /*if (isset($_GET['eposta'])) {
        echo '<span><a href="QuestionFormWithImage.php'.$parametroak.'">Galderak gehitu</a></span>';
        echo '<span><a href="ShowQuestions.php'.$parametroak.'">Galderak</a></span>';
        echo '<span><a href="ShowQuestionsWithImage.php'.$parametroak.'">Galderak irudiekin</a></span>';
        echo '<span><a href="ShowXmlQuestions.php'.$parametroak.'">Galderak (XML)</a></span>';
        echo '<span><a href="ShowJsonQuestions.php'.$parametroak.'">Galderak (JSON)</a></span>';
        echo '<span><a href="HandlingQuizesAjax.php'.$parametroak.'">AJAX galderen kudeaketa</a></span>';
        if ($_GET['rola']==='Irakaslea'){
            echo '<span><a href="IsVip.php'.$parametroak.'">VIP da?</a></span>';
            echo '<span><a href="AddVip.php'.$parametroak.'">Gehitu VIP</a></span>';
            //echo '<span><a href="HandlingQuizesAjax.php'.$parametroak.'">Ezabatu VIP</a></span>';
            echo '<span><a href="ShowVips.php'.$parametroak.'">Zerrendatu VIP</a></span>';
        }
    }*/
    echo '<span><a href="PlayGame.php">Galderak erantzun</a></span>';
    if (isset($_SESSION['rola'])){
    if ($_SESSION['rola']=='Ikaslea'){
        echo '<span><a href="HandlingQuizesAjax.php">AJAX galderak kudeatu</a></span>';
    }else{
    if ($_SESSION['rola']=='Irakaslea'){
        echo '<span><a href="IsVip.php">VIP da?</a></span>';
        echo '<span><a href="AddVip.php">Gehitu VIP</a></span>';
        echo '<span><a href="ShowVips.php">Zerrendatu VIP</a></span>';
        echo '<span><a href="DeleteVip.php">Ezabatu VIP</a></span>';
        echo '<span><a href="HandlingQuizesAjax.php">AJAX galderak kudeatu</a></span>';
    }else if ($_SESSION['rola']=='Admin'){
        echo '<span><a href="HandlingAccounts.php">Kontuak maneiatu</a></span>';
        }
    }   
    }
    echo '<span><a href="Credits.php">Kredituak</a></span>';
    ?>
</nav>

