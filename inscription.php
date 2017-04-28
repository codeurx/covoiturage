<?php session_start();
if(isset($_SESSION['userid']))
    header('Location:Accueil');
require 'inc/Database.php';
$db = new Database();
$listannonces = $db->GetAnnonces();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="icon" type="image/png" href="img/favicon.png"/>
    <title>Covoiturage - Inscription</title>
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
                    <li class="active"><a href="Inscription">Inscription</a></li>
                    <li><a href="Connexion">Se Connecter</a></li>
                </ul>
                <div class="navbar-form navbar-right">
                    <a href="AjoutTrajet" class="btn btn-success">Publier un Trajet</a>
                </div>
            </div>
        </nav>
    </header>
    <div class="row">
        <div class="col-md-12">
            <div class="text-center">
                <h1 class="main-heading ins">Créer Votre Compte</h1>
            </div>
                <form id="ins" class="form-horizontal">
                    <div class="form-group col-md-6">
                        <div class="col-md-12 frm-elem">
                            <input type="text" class="form-control" name="fname" placeholder="Nom" required>
                        </div>
                        <div class="col-md-12 frm-elem">
                            <input type="email" class="form-control" name="mail" placeholder="E-Mail" required>
                        </div>
                        <div class="col-md-12 frm-elem">
                            <input type="text" id="datepicker" class="form-control" name="birthdate" placeholder="Date Naissance" required>
                        </div>
                        <div class="col-md-12 frm-elem">
                            <input type="text"  class="form-control" name="tel" placeholder="Numéro Téléphone" pattern=".{8,12}" required>
                        </div>
                    </div>
                    <div class="form-group col-md-6">
                        <div class="col-md-12 frm-elem">
                            <input type="text" class="form-control" name="lname" placeholder="Prénom" required>
                        </div>
                        <div class="col-md-12 frm-elem">
                            <input type="password" class="form-control" name="password" placeholder="Mot de passe" required>
                        </div>
                        <div class="col-md-12 frm-elem">
                            <select name="gender" class="form-control">
                                <option>Homme</option>
                                <option>Femme</option>
                            </select>
                        </div>
                    </div>
                    <button id="submit_ins" class="btn btn-success">Enregistrer</button>
                </form>
            </div>
        <div class="col-md-12">
            <br><br>
            <div class="alert alert-dismissable">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                <div class="alert-holder"></div>
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
                                    <span class="tag col-md-12">Opel Astra</span>
                                    <span class="price">Prix par place : 15dt</span>
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