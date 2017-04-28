<?php
session_start();
if (isset($_GET['Logout'])){
    unset($_SESSION['userid']);
header('Location:Accueil');
}
require 'inc/Database.php';
$db = new Database();
if (isset($_SESSION['userid'])){
    $userinfo = $db->GetUserInfo($_SESSION['userid']);
    foreach ($userinfo as $user){
        $username = $user['fname'].' '.$user['lname'];
    }
}
if (isset($_POST['search'])){
    header('Location:Rechercher-'.$_POST['depart'].'-'.$_POST['arrive']);
}
$listannonces = $db->GetAnnonces();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="icon" type="image/png" href="img/favicon.png"/>
    <title>Covoiturage</title>
</head>
<body>
<div id="wrapper" class="container well">
    <header>
        <nav class="navbar navbar-inverse">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand animated slideInDown" href="#"><img src="img/logo.png"></a>
            </div>
            <div class="navbar-collapse collapse">
                <ul class="nav navbar-nav">
                    <li class="active"><a href="Accueil">Accueil</a></li>
                    <?php if (!isset($_SESSION['userid'])){ ?>
                        <li><a href="Inscription">Inscription</a></li>
                        <li><a href="Connexion">Se Connecter</a></li>
                    <?php } ?>
                    <?php
                    if (isset($_SESSION['userid'])) { ?>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> <?=$username;?> <b
                                    class="caret"></b></a>
                            <ul class="dropdown-menu">
                                <li><a href="Profil">Profil</a></li>
                                <li><a href="MesAnnonces">Mes Annonces</a></li>
                                <li class="divider"></li>
                                <li><a href="?Logout">Se Déconnecter</a></li>
                            </ul>
                        </li>
                    <?php } ?>
                </ul>
                <div class="navbar-form navbar-right">
                    <a href="AjoutTrajet" class="btn btn-success">Publier un Trajet</a>
                </div>
            </div>
        </nav>
    </header>
    <ul class="bxslider">
        <li><img class="img-slider img-responsive" src="img/slide-1.jpg"/></li>
        <li><img class="img-slider img-responsive" src="img/slide-2.jpg"/></li>
        <li><img class="img-slider img-responsive" src="img/slide-3.jpg"/></li>
        <li><img class="img-slider img-responsive" src="img/slide-4.png"/></li>
    </ul>
    <div class="row">
        <div class="col-md-12">
            <div class="search-form col-md-12">
                <form action="Accueil" method="post" class="form-horizontal">
                    <div class="form-group col-md-5">
                        <label class="col-md-5 control-label left">Lieu de départ</label>
                        <div class="col-md-7">
                            <select id="depart" name="depart" class="form-control">
                                <option>Ariana</option>
                                <option>Béja</option>
                                <option>Ben Arous</option>
                                <option>Bizerte</option>
                                <option>Gabès</option>
                                <option>Gafsa</option>
                                <option>Jendouba</option>
                                <option>Kairouan</option>
                                <option>Kasserine</option>
                                <option>Kébili</option>
                                <option>Le Kef</option>
                                <option>Mahdia</option>
                                <option>La Manouba</option>
                                <option>Médenine</option>
                                <option>Monastir</option>
                                <option>Nabeul</option>
                                <option>Sfax</option>
                                <option>Sidi Bouzid</option>
                                <option>Siliana</option>
                                <option>Sousse</option>
                                <option>Tataouine</option>
                                <option>Touzeur</option>
                                <option>Tunis</option>
                                <option>Zaghouan</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group col-md-5">
                        <label class="col-md-5 control-label left">Lieu d'arrivée</label>
                        <div class="col-md-7">
                            <select id="arrive" name="arrive" class="form-control">
                                <option>Ariana</option>
                                <option>Béja</option>
                                <option>Ben Arous</option>
                                <option>Bizerte</option>
                                <option>Gabès</option>
                                <option>Gafsa</option>
                                <option>Jendouba</option>
                                <option>Kairouan</option>
                                <option>Kasserine</option>
                                <option>Kébili</option>
                                <option>Le Kef</option>
                                <option>Mahdia</option>
                                <option>La Manouba</option>
                                <option>Médenine</option>
                                <option>Monastir</option>
                                <option>Nabeul</option>
                                <option>Sfax</option>
                                <option>Sidi Bouzid</option>
                                <option>Siliana</option>
                                <option>Sousse</option>
                                <option>Tataouine</option>
                                <option>Touzeur</option>
                                <option>Tunis</option>
                                <option>Zaghouan</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group col-md-2">
                        <button name="search" type="submit" class="btn btn-success">Rechercher</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-md-12 text-center">
            <h1 class="main-heading">Le site de covoiturage en Tunisie</h1>
        </div>
        <div class="col-md-12">
            <div class="col-md-6 text-center">
                <a href="">
                    <img src="img/passenger.png"/>
                    <h1>Vous êtes Passager?</h1>
                    <p>Grâce au site Covoiturage vous pouvez se déplacer moins cher et avoir des nouveaux amis.</p>
                </a>
            </div>
            <div class="col-md-6 text-center">
                <a href="Connexion">
                    <img src="img/driver.jpg"/>
                    <h1>Vous êtes Conducteur?</h1>
                    <p>Le covoiturage vous permet de réduire les coûts de vos déplacements.</p>
                </a>
            </div>
        </div>
        <hr>
        <div class="col-md-12 text-center">
            <h1 class="main-heading">Les Dernières Annonces</h1>
        </div>
        <div class="col-md-12">
            <div id="acts" class="owl-carousel owl-theme">
                <?php foreach ($listannonces as $a){ ?>
                    <div class="item act-content">
                        <a href="Detail-Annonce-<?=$a['idtrajet'];?>">
                            <div class="im-container">
                                <img class="img-responsive" src="img/<?=$a['avatar'];?>" alt="">
                            </div>
                            <div class="text-center holder">
                                <h4>De <?=$a['depart'];?> à <?=$a['arriver'];?></h4>
                                <span class="tag col-md-12"><?=$a['mark'];?></span>
                                <span class="price">Prix par place : <?=$a['price'];?>dt</span>
                            </div>
                        </a>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
    <footer class="text-center footer">
        &copy; 2017 Covoiturage - Tous droits Réservés.
    </footer>
</div>
<script type="text/javascript" src="js/jquery-latest.min.js"></script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/jquery.bxslider.min.js"></script>
<script type="text/javascript" src="js/owl.carousel.min.js"></script>
<script type="text/javascript" src="js/jquery-ui.js"></script>
<script type="text/javascript" src="js/app.js"></script>
</body>
</html>