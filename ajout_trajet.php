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
    $pic = $user['avatar'];
    $gender = $user['gender'];
    $username = $user['fname'] . ' ' . $user['lname'];
    $birthdate = $user['birthdate'];
    $date_login = date('d-m-Y', strtotime($user['date_login']));
    $date_inscri = date('d-m-Y', strtotime($user['register_date']));
    $tabac = $user['tabac'];
    $tel = $user['tel'];
    $profession = $user['profession'];
}
$listannonces = $db->GetAnnonces();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="icon" type="image/png" href="img/favicon.png"/>
    <title>Covoiturage - Publier un Trajet</title>
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
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i
                                class="fa fa-user"></i> <?= $username; ?> <b
                                class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li><a href="Profil">Profil</a></li>
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
        <?php
        if ($vehicle == 0){
            ?>
            <div class="col-md-12">
                <div class="text-center">
                    <h1 class="main-heading">Vous devez compléter les caractéristiques de votre voiture</h1>
                </div>
            </div>
        <?php }else{ ?>
        <div class="col-md-12">
            <div class="text-center"><h1 class="main-heading">Publier un Trajet</h1></div>
        </div>
        <div class="col-md-6">
            <form id="trajet" class="form-horizontal">
                <div class="form-group">
                    <div class="col-md-6">
                        <label class="control-label"><i class="fa fa-map-marker"></i> Lieu de Départ</label>
                        <input type="text" class="form-control autocomplete" name="start" id="start"/>
                    </div>
                    <div class="col-md-6">
                        <label class="control-label"><i class="fa fa-map-marker"></i> Lieu D'arrivée</label>
                        <input type="text" class="form-control autocomplete" name="destination" id="destination"/>
                    </div>
                </div>
                <label class="control-label"><i class="fa fa-thumb-tack"></i> étapes</label>
                <div id="ways">
                    <div class="btn-group">
                        <label class="control-label"><i class="fa fa-location-arrow"></i> ville étape</label><br>
                        <input type="text" class="form-control autocomplete way" name="way_1" id="way_1">
                    </div>
                </div>
                <br>
                <button class="btn btn-success" id="add_way">Ajouter étape</button>
                <div class="form-group">
                    <div class="col-md-6">
                        <div class="contain">
                            <label class="control-label"><i class="fa fa-exchange"></i> Aller/Retour</label><br>
                            Oui <input type="radio" name="ar" value="oui">
                            Non <input type="radio" name="ar" value="non"><br>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="contain">
                            <label class="control-label"><i class="fa fa-road"></i> Trajet</label><br>
                            Régulier <input type="radio" class="traj" name="trajet" value="Régulier">
                            Non Régulier <input type="radio" class="traj" name="trajet" value="Non Régulier">
                        </div>
                    </div>
                </div>
                <div class="date">
                    <label class="control-label"><i class="fa fa-calendar"></i> Date</label>
                    <input type="text" class="form-control" name="date" id="date">
                </div>
                <label class="control-label"><i class="fa fa-clock-o"></i> Horaire</label>
                <input placeholder="Heure (hh:mm)" name="time" id="time" type="time" class="form-control"><br>
                <div class="form-group">
                    <div class="col-md-6">
                        <label class="control-label"><i class="fa fa-users"></i> Nombre des Places</label>
                        <input type="number" min="1" max="8" name="places" id="places" class="form-control">
                    </div>
                    <div class="col-md-6">
                        <label class="control-label"><i class="fa fa-dollar"></i> Prix de place</label>
                        <input type="number" class="form-control" name="price" id="price" min="1">
                    </div>
                </div>
                <button id="sub_trajet" class="btn btn-success">Enregistrer</button>
            </form>
            <div class="col-md-12">
                <br><br>
                <div class="alert alert-dismissable">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <div class="alert-holder"></div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div id='map_canvas' class="map"></div>
        </div>
    </div>
    <?php }
    ?>
    <div class="col-md-12 text-center">
        <h1 class="main-heading">Les Dernières Annonces</h1>
    </div>
    <div class="col-md-12">
        <div id="acts" class="owl-carousel owl-theme">
            <?php foreach ($listannonces as $a) { ?>
                <div class="item act-content">
                    <a href="Detail-Annonce-<?= $a['idtrajet']; ?>">
                        <div class="im-container">
                            <img class="img-responsive" src="img/<?= $a['avatar']; ?>" alt="">
                        </div>
                        <div class="text-center holder">
                            <h4>De <?= $a['depart']; ?> à <?= $a['arriver']; ?></h4>
                            <span class="tag col-md-12"><?= $a['mark']; ?></span>
                            <span class="price">Prix par place : <?= $a['price']; ?>dt</span>
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
</div>
<script type="text/javascript"
        src="http://maps.google.com/maps/api/js?key=AIzaSyCnj8361bRDFrYvdj39LJCXxeVIA73sTKI&libraries=places"></script>
<script type="text/javascript" src="js/jquery-latest.min.js"></script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/jquery.bxslider.min.js"></script>
<script type="text/javascript" src="js/owl.carousel.min.js"></script>
<script type="text/javascript" src="js/jquery-ui.js"></script>
<script type="text/javascript" src="js/jquery.validate.min.js"></script>
<script type="text/javascript" src="js/app.js"></script>
<script type="text/javascript">
    $(function () {
        $('#sub_trajet').click(function () {
            var frm = $('#trajet');
            function dateRequired() {
                return $('.traj:checked').val()== 'Non Régulier';
            }
            frm.validate({
                ignore: [],
                rules:{
                    start : {
                        required: true,
                        minlength: 3
                    },
                    destination : {
                        required: true,
                        minlength: 3
                    },
                    way_1 : {
                        minlength: 3
                    },
                    ar : {
                        required : true
                    },
                    trajet : {
                        required : true
                    },
                    date : {
                        required : dateRequired
                    },
                    time : {
                        required : true
                    },
                    places : {
                        required : true
                    },
                    price : {
                        required : true
                    }
                },
                messages:{
                    start : {required: "Veuillez saisissez la ville de départ" ,minlength: "Au moins 3 caractères"},
                    destination : {required: "Veuillez saisissez la ville d'arrivé" ,minlength: "Au moins 3 caractères"},
                    way_1 : {minlength: "Au moins 3 caractères"},
                    ar : {required: "<p>Champs Obligatoire</p>"},
                    trajet : {required: "<p>Champs Obligatoire</p>"},
                    date : {required: "Veuillez saisissez la date"},
                    time : {required: "Veuillez saisissez l'horaire"},
                    places : {required: "Veuillez saisissez le nombre des places"},
                    price : {required: "Veuillez saisissez le prix/place"}
                },
                errorPlacement: function(error, element)
                {
                    if ( element.is(":radio") )
                    {
                        error.appendTo( element.parents('.contain') );
                    }
                    else
                    {
                        error.insertAfter( element );
                    }
                },
                submitHandler: submitForm
            });
            function submitForm(){
                $.ajax({
                    type: "POST",
                    url: "SubmitTrajet",
                    data: new FormData(frm[0]),
                    contentType: false,
                    processData: false,
                    success: function (data) {
                        if (data.status == 'success') {
                            $('.alert').slideUp('slow');
                            $('.alert').removeClass('alert-danger');
                            $('.alert').addClass('alert-success');
                            $('.alert-holder').html('<strong>Trajet Enregistré avec succés ...</strong>');
                            $('.alert').slideDown('slow', function () {
                                setTimeout(function () {
                                    document.location.href = 'MesAnnonces';
                                }, 3000)
                            });
                        }
                    }
                });
            }
        });
        $.datepicker.regional['fr'] = {
            minDate: new Date,
            maxDate: '1000'
        };
        $.datepicker.setDefaults($.datepicker.regional['fr']);
        initialize();
        getPlace_dynamic();
        $('#destination').focusout(function () {
            calcRoute();
        });
        $('#start').focusout(function () {
            calcRoute();
        });
        $(document).on('focusout', '.way', function () {
            calcRoute();
        });
        var i = 2;
        $(document).on('click', '#add_way', function (e) {
            $('#ways').append('<div class="btn-group"><label class="control-label"><i class="fa fa-location-arrow"></i> ville étape</label><br><input type="text" class="form-control autocomplete way" name="way_' + i + '" id="way_' + i + '"> <span class="fa fa-remove wayclear"></span> </div>');
            getPlace_dynamic();
            i++;
            if($('.way').length == 4){
                $('#add_way').prop('disabled', true);
            }
            e.preventDefault();
        });
        $('.traj').change(function () {
            if ($(this).val() == 'Régulier')
                $('.date').slideUp('slow');
            else
                $('.date').slideDown('slow');
        });
        $(document).on('click', '.wayclear', function () {
            $(this).parent().remove();
            if($('.way').length < 4){
                $('#add_way').prop('disabled', false);
            }
            calcRoute();
        });
        var map;
        var directionsService = new google.maps.DirectionsService();

        function initialize() {
            var rendererOptions = {
                draggable: false
            };
            directionsDisplay = new google.maps.DirectionsRenderer(rendererOptions);
            var my_place = new google.maps.LatLng(34.7178014, 10.2201819);
            var myOptions = {
                zoom: 6,
                mapTypeId: google.maps.MapTypeId.ROADMAP,
                center: my_place
            }
            map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);
            directionsDisplay.setMap(map);
        }

        function getPlace_dynamic() {
            var defaultBounds = new google.maps.LatLngBounds(
                new google.maps.LatLng(-33.8902, 151.1759),
                new google.maps.LatLng(-33.8474, 151.2631));
            var input = $('.autocomplete');
            var options = {
                bounds: defaultBounds,
                types: ['(cities)'],
                componentRestrictions: {country: 'tn'}
            };
            for (i = 0; i < input.length; i++) {
                autocomplete = new google.maps.places.Autocomplete(input[i], options);
            }
        }

        function calcRoute() {
            var waypts = [];
            $('.way').each(function () {
                if ($(this).val() != '')
                    waypts.push({
                        location: $(this).val(),
                        stopover: true
                    });
            });
            var start = document.getElementById("start").value;
            var end = document.getElementById("destination").value;
            var request = {
                origin: start,
                destination: end,
                waypoints: waypts,
                optimizeWaypoints: true,
                travelMode: google.maps.DirectionsTravelMode.DRIVING
            };
            directionsService.route(request, function (response, status) {
                if (status == google.maps.DirectionsStatus.OK) {
                    directionsDisplay.setDirections(response);
                    var route = response.routes[0];
                    for (var i = 0; i < route.legs.length; i++) {
                        console.log(route.legs[i]);
                    }
                }
            });
        }
    });
</script>
</body>
</html>