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
$vehicle = $db->GetVehicleInfo($_SESSION['userid']);
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
$listannonces    = $db->GetAnnonces();
$totalannonces   = $db->TotalAnnonces($_SESSION['userid']);
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="icon" type="image/png" href="img/favicon.png"/>
    <title>Covoiturage - Profil</title>
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
                            <li class="active"><a href="Profil">Profil</a></li>
                            <li><a href="MesAnnonces">Mes Annonces</a></li>
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
            <div class="col-md-4">
                <div class="profil">
                    <h1>Activités</h1>
                    <ul>
                        <li><b>Annonces Publiés :</b> <?=$totalannonces;?></li>
                        <li><b>Dernière Connexion :</b> <?= $date_login; ?></li>
                        <li><b>Date Inscription :</b> <?= $date_inscri; ?></li>
                    </ul>
                    <h1>Voiture</h1>
                    <?php
                    if ($vehicle == 0) {
                        echo 'Non Précisé';
                    } else {
                        foreach ($vehicle as $v) {
                            $mark = $v['mark'];
                            $color = $v['color'];
                            $air_cond = $v['air_cond'];
                        }
                        ?>
                        <ul>
                            <li><b><?= $mark; ?></b></li>
                            <li><b>Couleur :</b> <?= $color; ?></li>
                            <li><b>Climatiseur : </b><?= $air_cond; ?></li>
                        </ul>
                    <?php }
                    ?>
                </div>
            </div>
            <div class="col-md-8">
                <div>
                    <div class="profile-pic">
                        <img src="img/<?= $pic; ?>" class="profile-pic profilepic img-circle"/>
                    </div>
                </div>
                <div class="col-md-12">
                    <b><?= $username . ' (' . date_diff(date_create($birthdate), date_create('today'))->y . ' ans)'; ?></b>
                    <ul>
                        <li><?= $gender; ?></li>
                        <li>Téléphone : <?= $tel; ?></li>
                        <li>Profession : <b><?=$profession;?></b></li>
                        <li>Mes Préférences : Tabac <?= $tabac; ?></li>
                    </ul>
                </div>
                <button class="btn btn-success" id="ShowHidePrefForm">Modifier Mes Préférences</button>
                <div class="col-md-12">
                    <?php
                    if ($vehicle == 0) {
                        $mark = 'Non Précisé';
                        $color = 'Non Précisé';
                        $air_cond = 'Non Précisé';
                    } else {
                    foreach ($vehicle as $v) {
                        $mark = $v['mark'];
                        $color = $v['color'];
                        $air_cond = $v['air_cond'];
                    }
                    }
                    ?>
                    <div class="suivi">
                        <form id="suivi" class="form-horizontal" enctype="multipart/form-data">
                            <div class="form-group">
                                <label class="col-md-3 control-label">Nouvelle Photo</label>
                                <div class="col-md-9">
                                    <div class="input-group">
                                        <input type="text" class="form-control" readonly>
                                        <label class="input-group-btn">
                                        <span class="btn btn-success">
                                            Parcourir&hellip; <input type="file" name="profilepic" id="profilepic" style="display: none;">
                                        </span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Profession</label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" name="profession" value="<?=$profession;?>" placeholder="Profession" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Marque de Voiture</label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" name="mark" value="<?=$mark;?>" placeholder="Marque de Voiture" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Couleur de Voiture</label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" name="color" value="<?=$color;?>" placeholder="Couleur de Voiture" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Climatiseur</label>
                                <div class="col-md-9">
                                    <select name="air" class="form-control">
                                        <option><?=$air_cond;?></option>
                                        <option>Climatisée</option>
                                        <option>Non Climatisée</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Tabac</label>
                                <div class="col-md-9">
                                    <select name="tabac" class="form-control">
                                        <option><?=$tabac;?></option>
                                        <option>Autorisé</option>
                                        <option>Non Autorisé</option>
                                    </select>
                                </div>
                            </div>
                            <button class="btn btn-success" id="sub_suivi">Mettre à Jour</button>
                        </form>
                        <div class="col-md-12">
                            <br><br>
                            <div class="alert alert-dismissable">
                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                <div class="alert-holder"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
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