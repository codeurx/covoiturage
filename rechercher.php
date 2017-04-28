<?php
session_start();
if (isset($_GET['Logout'])) {
    unset($_SESSION['userid']);
    header('Location:Accueil');
}
require 'inc/Database.php';
$db = new Database();
if (isset($_SESSION['userid'])){
    $userinfo = $db->GetUserInfo($_SESSION['userid']);
    foreach ($userinfo as $user) {
        $username    = $user['fname'] . ' ' . $user['lname'];
    }
}
$depart = $_GET['depart'];
$arrive = $_GET['arrive'];
$res    = $db->Search($depart,$arrive);
$listannonces = $db->GetAnnonces();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="icon" type="image/png" href="img/favicon.png"/>
    <title>Covoiturage - Rechercher de <?=$depart?> à <?=$arrive;?></title>
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
                    <li><a href="Accueil">Accueil</a></li>
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
                                <li><a href="<?=$_SERVER['REQUEST_URI'];?>&Logout">Se Déconnecter</a></li>
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
    <div class="row">
        <div class="col-md-12">
            <?php
            if ($res == 0){ ?>
                <div class="text-center">
                    <h1 class="main-heading">Résultat de Recherche du Trajet de <?=$_GET['depart'];?> à <?=$_GET['arrive'];?></h1>
                </div>
                <div class="text-center">
                    <h1 class="main-heading" style="color:red;">Aucune Annonce Trouvée </h1>
                </div>
            <?php }else{ ?>
                <div class="text-center">
                    <h3 class="main-heading">Résultat de Recherche du Trajet de <?=$_GET['depart'];?> à <?=$_GET['arrive'];?></h3>
                </div>
               <?php
                foreach ($res as $r){?>
                <div class="col-md-12 annonce record">
                    <div class="col-md-3">
                        <div class="profile-pic">
                            <img src="img/<?=$r['avatar'];?>" class="profile-pic img-circle" />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <a style="color:#3c763d;" href="Detail-Annonce-<?=$r['idtrajet'];?>">De <?=$r['depart'];?> à <?=$r['arriver'];?></a><br><br>
                        <i class="fa fa-clock-o"></i> <?=$r['time'];?> <i class="fa fa-calendar"></i> <?=$r['date'];?> <i class="fa fa-money"></i> <?=$r['price'];?> DT/Place
                    </div>
                    <div class="col-md-3">
                        <a href="Detail-Annonce-<?=$r['idtrajet'];?>" class="btn btn-success ann"><i class="fa fa-eye"></i> Consulter</a>
                    </div>
                </div>
            <?php } }?>
        </div>
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
