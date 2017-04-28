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
        $u_name    = $user['fname'] . ' ' . $user['lname'];
    }
}

$annonce = $db->GetAnnonceDetails(addslashes($_GET['id']));
foreach ($annonce as $a){
    $depart = $a['depart'];
    $arriver = $a['arriver'];
    $price   = $a['price'];
    $ar     = $a['aller_retour'];
    $vehicleid  = $a['vehicleid'];
    $iduser     = $a['userid'];
    $places     = $a['places'];
    $date       = $a['date'];
    $time       = $a['time'];
    $trajet       = $a['trajet'];
}
$vehicle = $db->GetVehicleInfo($iduser);
foreach ($vehicle as $v){
    $mark = $v['mark'];
    $color = $v['color'];
    $air_cond = $v['air_cond'];
}
$user    = $db->GetUserInfo($iduser);
foreach ($user as $u){
    $avatar = $u['avatar'];
    $username = $u['fname'].' '.$u['lname'];
    $tel      = $u['tel'];
    $tabac    = $u['tabac'];
}
$listannonces = $db->GetAnnonces();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="icon" type="image/png" href="img/favicon.png"/>
    <title>Covoiturage - De <?=$depart;?> à <?=$arriver;?></title>
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
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> <?=$u_name;?> <b
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
           <div class="col-md-4">
               <img src="img/<?=$avatar;?>" class="annonce-img img-circle">
           </div>
            <div class="col-md-8">
                <div class="col-md-12">
                    <div class="annonce-content">
                        <i class="fa fa-road"></i> De <span><?=$depart;?></span> à <span><?=$arriver;?></span>
                    </div>
                    <div class="annonce-content">
                        <i class="fa fa-user"></i> Annonceur : <span><?=$username;?></span>
                    </div>
                    <div class="annonce-content">
                        <i class="fa fa-users"></i> Places Disponibles : <span><?=$places;?></span> <i class="fa fa-money"></i> Prix : <span><?=$price;?></span> DT/Place
                    </div>
                    <div class="annonce-content">
                        <i class="fa fa-cab"></i> Voiture : <span><?=$mark;?></span> <i class="fa fa-clock-o"></i> Heure : <span><?=$time;?></span> <i class="fa fa-calendar"></i> Date : <span><?=$date;?></span>
                    </div>
                    <div class="annonce-content">
                        <i class="fa fa-phone"></i> Téléphone : <span><?=$tel;?></span>
                    </div>
                    <div class="annonce-content">
                        <i class="fa fa-exchange"></i> Aller/Retour : <span><?=$ar;?></span> <i class="fa fa-road"></i> Trajet : <span><?=$trajet;?></span>
                    </div>
                    <div class="annonce-content">
                        <i class="fa fa-cloud-download"></i> Climatiseur : <span><?=$air_cond;?></span> <i class="fa fa-fire"></i> Tabac : <span><?=$tabac;?></span>
                    </div>
                </div>
            </div>
            <div class="col-md-12"><div class="text-center"><button id="takeplace" data-id="<?=$_GET['id'];?>" class="btn btn-success" <?php if($places == 0){echo 'disabled';}?>>Réserver une Place</button></div></div>
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
