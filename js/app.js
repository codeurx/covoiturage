$(function () {
    $.datepicker.regional['fr'] = {
        closeText: 'Fermer',
        prevText: '&#x3c;Préc',
        nextText: 'Suiv&#x3e;',
        currentText: 'Aujourd\'hui',
        monthNames: ['Janvier','Fevrier','Mars','Avril','Mai','Juin',
            'Juillet','Aout','Septembre','Octobre','Novembre','Decembre'],
        monthNamesShort: ['Jan','Fev','Mar','Avr','Mai','Jun',
            'Jul','Aou','Sep','Oct','Nov','Dec'],
        dayNames: ['Dimanche','Lundi','Mardi','Mercredi','Jeudi','Vendredi','Samedi'],
        dayNamesShort: ['Dim','Lun','Mar','Mer','Jeu','Ven','Sam'],
        dayNamesMin: ['Di','Lu','Ma','Me','Je','Ve','Sa'],
        weekHeader: 'Sm',
        dateFormat: 'dd-mm-yy',
        firstDay: 1,
        isRTL: false,
        showMonthAfterYear: false,
        yearSuffix: '',
        maxDate: new Date,
        numberOfMonths: 1,
        changeMonth: true,
        changeYear: true,
        showButtonPanel: true
    };
    $.datepicker.setDefaults($.datepicker.regional['fr']);
    $('.bxslider').bxSlider({
        auto: true, pager: false,
        nextText: 'Onward →',
        prevText: '← Go back'
    });
    $('#acts').owlCarousel({
        navigation: true,
        slideSpeed: 300,
        margin: 10,
        autoPlay: 3000,
        paginationSpeed: 400,
        singleItem: false,
        navigation: true,
        pagination: false,
        navigationText: ['<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>'],
        items: 4,
        itemsDesktop: [1199, 3],
        itemsDesktopSmall: [980, 3],
        itemsTablet: [768, 2],
        itemsTabletSmall: [480, 2],
        itemsMobile: [479, 1]
    });
    //inscription
    $('#submit_ins').click(function(){
        $('#ins').submit(function(e){
            e.preventDefault();
            var frm = $('#ins');
            var fdpost = new FormData(frm[0]);
            $.ajax({
                type : "POST",
                url  : "ValidateInscription",
                data : fdpost,
                contentType: false,
                processData: false,
                success :  function(data)
                {
                    if(data.status == 'success'){
                        $('.alert').slideUp('slow');
                        $('.alert').removeClass('alert-danger');
                        $('.alert').addClass('alert-success');
                        $('.alert-holder').html('<strong>Inscription avec succés</strong>');
                        $('.alert').slideDown('slow');
                    }else if(data.status == 'verif'){
                        $('.alert').slideUp('slow');
                        $('.alert').removeClass('alert-success');
                        $('.alert').addClass('alert-danger');
                        $('.alert-holder').html('<strong>E-mail déja utilisé!</strong>');
                        $('.alert').slideDown('slow');
                    }
                }
            });
        });
    });
    //connexion
    $('#submit_cnx').click(function(){
        $('#cnx').submit(function(e){
            e.preventDefault();
            var frm = $('#cnx');
            var fdpost = new FormData(frm[0]);
            $.ajax({
                type : "POST",
                url  : "ValidateCnx",
                data : fdpost,
                contentType: false,
                processData: false,
                success :  function(data)
                {
                    if(data.status == 'success'){
                        $('.alert').slideUp('slow');
                        $('.alert').removeClass('alert-danger');
                        $('.alert').addClass('alert-success');
                        $('.alert-holder').html('<strong>Connexion avec succés, Redirection ...</strong>');
                        $('.alert').slideDown('slow',function(){setTimeout(function(){
                            document.location.href = 'Profil';
                        }, 3000)});
                    }else if(data.status == 'verif'){
                        $('.alert').slideUp('slow');
                        $('.alert').removeClass('alert-success');
                        $('.alert').addClass('alert-danger');
                        $('.alert-holder').html('<strong>Veuillez vérifier vos cordonnées!</strong>');
                        $('.alert').slideDown('slow');
                    }
                }
            });
        });
    });
    $( "#datepicker" ).datepicker();
    $(document).on('change', ':file', function() {
        var input = $(this),
            numFiles = input.get(0).files ? input.get(0).files.length : 1,
            label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
        input.trigger('fileselect', [numFiles, label]);
    });

    // We can watch for our custom `fileselect` event like this
    $(document).ready( function() {
        $(':file').on('fileselect', function(event, numFiles, label) {

            var input = $(this).parents('.input-group').find(':text'),
                log = numFiles > 1 ? numFiles + ' files selected' : label;

            if( input.length ) {
                input.val(log);
            } else {
                if( log ) alert(log);
            }

        });
    });
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('.profilepic').attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]);
        }
    }

    $("#profilepic").change(function(){
        readURL(this);
    });
    $('#ShowHidePrefForm').click(function () {
        $('.suivi').toggle('slow');
    });
    $('#sub_suivi').click(function () {
        $('#suivi').submit(function(e){
            e.preventDefault();
            var frm = $('#suivi');
            var fdpost = new FormData(frm[0]);
            $.ajax({
                type : "POST",
                url  : "UpdateProfile",
                data : fdpost,
                contentType: false,
                processData: false,
                success :  function(data)
                {
                    if(data.status == 'success'){
                        $('.alert').slideUp('slow');
                        $('.alert').removeClass('alert-danger');
                        $('.alert').addClass('alert-success');
                        $('.alert-holder').html('<strong>Profil mis à jour avec succés, Redirection ...</strong>');
                        $('.alert').slideDown('slow',function(){setTimeout(function(){
                            document.location.href = 'Profil';
                        }, 3000)});
                    }
                }
            });
        });
    });
    $( "#date" ).datepicker();
    $('#sub_trajet').click(function () {
        $('#trajet').submit(function(e){
            e.preventDefault();
            var frm = $('#trajet');
            var fdpost = new FormData(frm[0]);
            $.ajax({
                type : "POST",
                url  : "SubmitTrajet",
                data : fdpost,
                contentType: false,
                processData: false,
                success :  function(data)
                {
                    if(data.status == 'success'){
                        $('.alert').slideUp('slow');
                        $('.alert').removeClass('alert-danger');
                        $('.alert').addClass('alert-success');
                        $('.alert-holder').html('<strong>Trajet Enregistré avec succés ...</strong>');
                        $('.alert').slideDown('slow',function(){setTimeout(function(){
                            document.location.href = 'MesAnnonces';
                        }, 3000)});
                    }
                }
            });
        });
    });
    $('.delete').click(function (e) {
        e.preventDefault();
        var element_id = $(this).attr("data-id");
        var info = 'id=' + element_id;
        var cur = $(this);
        if (confirm("Voulez vous vraiment Supprimer cette Annonce?")) {
            $.ajax({
                type: "POST",
                url: "Delete-Annonce-" + element_id,
                data: info,
                success: function (data) {
                    if (data.status == 'success') {
                        cur.parents(".record").css({"background-color": "red"}, "slow").animate({opacity: "hide"}, "slow");
                    }
                }
            });
        }
    });
    $('#search').submit(function(e){
        var frm = $('#search').serialize();
        var dep    = $('#depart').val();
        var arr    = $('#arrive').val();
        $.ajax({
            type: 'post',
            data: frm,
            url : "Rechercher-"+dep+"-"+arr
        });

    });
    $('#takeplace').click(function(){
        var d = {'id_trajet' : $(this).attr('data-id')}
        $.ajax({
            url: "Take-Traject",
            type: "POST",
            data: d,
            success: function (data) {
                if (data.status == 'success') {
                    $('#takeplace').html('<i class="fa fa-check"></i> Redirection...');
                    window.setTimeout(function(){location.reload();},3000);
                }
            }
        });
    });
});