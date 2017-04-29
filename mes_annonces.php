<?php
session_start();
if (isset($_GET['Logout'])) {
    unset($_SESSION['userid']);
    header('Location:Accueil');
}
if (!isset($_SESSION['userid']))
    header('Location:Accueil');
require 'inc/Database.php';
$db = new Database();
$userinfo = $db->GetUserInfo($_SESSION['userid']);
foreach ($userinfo as $user) {
    $pic         = $user['avatar'];
    $gender      = $user['gender'];
    $username    = $user['fname'] . ' ' . $user['lname'];
    $birthdate   = $user['birthdate'];
    $date_login  = date('d-m-Y', strtotime($user['date_login']));
    $date_inscri = date('d-m-Y', strtotime($user['register_date']));
    $tabac       = $user['tabac'];
    $tel         = $user['tel'];
    $profession  = $user['profession'];
}
$annonces     = $db->GetUsersAnnonces($_SESSION['userid']);
$listannonces = $db->GetAnnonces();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="icon" type="image/png" href="img/favicon.png"/>
    <title>Covoiturage - Mes Annonces</title>
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
                    <li class="active dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i
                                class="fa fa-user"></i> <?= $username; ?> <b
                                class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li><a href="Profil">Profil</a></li>
                            <li class="active"><a href="MesAnnonces">Mes Annonces</a></li>
                            <li class="divider"></li>
                            <li><a href="?Logout">Se Déconnecter</a></li>
                        </ul>
                    </li>
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
            if ($annonces == 0){?>
                <div class="text-center">
                    <h1 class="main-heading">Mes Annonces</h1>
                </div>
                <div class="text-center">
                    <h1 class="main-heading" style="color:red;">
                        Vous n'avez pas d'annonces en ligne.</h1>
                </div>
            <?php }else{
                foreach ($annonces as $annonce){
                    if ($annonce['date_t']!='0000-00-00'){
                        $date = ' <i class="fa fa-calendar"></i> '.date('d-m-Y',strtotime($annonce['date_t']));
                    }else{
                        $date = '';
                    }
                ?>
                    <div class="col-md-12 annonce record">
                        <div class="col-md-3">
                            <div class="profile-pic">
                                <img src="img/<?=$annonce['avatar'];?>" class="profile-pic img-circle" />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <a style="color:#3c763d;" href="Detail-Annonce-<?=$annonce['idtrajet'];?>">De <?=$annonce['depart'];?> à <?=$annonce['arriver'];?></a><br><br>
                            <i class="fa fa-clock-o"></i> <?=$annonce['time_t'];?><?=$date;?> <i class="fa fa-money"></i> <?=$annonce['price'];?> DT/Place
                        </div>
                        <div class="col-md-3">
                            <a href="Detail-Annonce-<?=$annonce['idtrajet'];?>" class="btn btn-success ann"><i class="fa fa-eye"></i> Consulter</a>
                            <button data-id="<?=$annonce['idtrajet'];?>" class="delete btn btn-danger ann"><i class="fa fa-trash-o"></i> Supprimer</button>
                        </div>
                    </div>
            <?php } } ?>
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
<script>
    $(function () {
        $.datepicker.regional['fr'] = {
            minDate: new Date,
            maxDate: '1000'
        };
        $.datepicker.setDefaults($.datepicker.regional['fr']);
    })
</script>
</body>
</html>