<?php
    $notif_mail = 0;
    require_once '../../controllers/Co2/getSession.php';

    // on a pas le droit de voir index si on était pas connecter au préalable.
    if(!$user)
    {   
         require_once 'modal.php';
    }

?>

<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="UTF-8">
	<title>SDPE - IoT co2</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">    
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css">
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
    <!-- CSS -->
    <link rel="stylesheet" href="/css/demo.css">
    <link rel="stylesheet" href="/css/historiqueCo2.css">
    <meta name="author" content="Yvon Benahita">
    <link rel="icon" type="image/png" href="/img/datastore-logo.png" />

	<!-- script pour la courbe -->
    <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
	<!-- ********************** -->

    <!-- font pour home-->
    <link rel="stylesheet" href="css/font-awesome/font-awesome.css">
</head>

<body>
    <?php require_once '../../controllers/Co2/getPourcNotAcceptable.php'; ?>;
    <?php require_once '../../controllers/Co2/sendmail.php'; ?>
    <?php require_once '../../resources/includes/header-co2.php'; ?>
    


<div class="container" id="contenu">  <!-- Pour tout le contenu de notre site -->

<!-- ===========================Le logo et le titre============================ -->
    <div class="row">
        <div class="col-md-12">
            <h1><img src="/img/datastore-logo.png" id="gds-logo" /> PHP & <span class="hidden-xs">Google</span> Cloud Datastore</h1>
        </div>
    </div>
<!-- ====================================================================== -->

	<!-- div permettant de visualiser la courbe -->
    <div align="center">  
        <h4 style="float: left;margin-bottom: 30px;">Instantaneous values</h4>
        <div class="mon_slide">
            <div id="slider">
            	<div id="co2" style="min-width: 310px; height: 400px;"></div><!-- div qui va contenir la courbe -->
           </div>
        </div>
    </div> <!-- fin div courbe -->
	

<script src="/js/charts-co2.js"></script> <!-- le script de la courbe lui même -->

<!-- ============================ Historiques ====================================== -->
<div class="col-md-8">
    <h2 style="margin-bottom: 30px;margin-left: -15px;">Historics</h2>
</div>
<div class="histCo2Tab">
    <table class="table stats caps histoco2">
        <thead class="titresHistCo2Tab">
            <tr>
                <td>Il y a 2 jours</td>
                <td>Hier</td>
                <td>Aujourd'hui</td>
                <td>Tous</td>
            </tr>
        </thead>
        <tbody>
            <tr style=""; border-radius:6px;"><!--Adjust bg and font colors inline-->
                <td><a href="/zone_1/home/co2/deuxjours"><button class="btn btn-primary" id="voirHistCo2Btn"><i class="fa fa-history" aria-hidden="true"></i>
                    </button></a></td>
                <td><a href="/zone_1/home/co2/hier"><button class="btn btn-primary" id="voirHistCo2Btn"><i class="fa fa-history" aria-hidden="true"></i>
                    </button></a></td>
                <td>Il y a <form method="POST" action="/zone_1/home/co2/histmin"><input type="text" name="aujourduiMinCo2" class="form-control" placeholder="mm" required>minute(s)<button type="submit" class="btn btn-primary" id="voirHistCo2Btn" style="margin-bottom: 3px; margin-left: 4px;"><i class="fa fa-history" aria-hidden="true"></i>
                    </button>
                    </form><br><br>
                Il y a <form method="POST" action="/zone_1/home/co2/histheure"><input type="text" name="aujourduiHeurCo2" class="form-control" placeholder="hh" required> heure(s)<button type="submit" class="btn btn-primary" id="voirHistCo2Btn" style="margin-bottom: 3px; margin-left: 4px;"><i class="fa fa-history" aria-hidden="true"></i>
                    </button></form>
                </td>
                <td><a href="/zone_1/home/co2/tous"><button class="btn btn-primary" id="voirHistCo2Btn"><i class="fa fa-history" aria-hidden="true"></i>
                    </button></a></td>
            </tr>
            <!--Spacer-->
            <tr class="spacing">
                <td colspan="4"></td><!--Colspan should match width of your table-->
            </tr>
            <!--End Spacer-->
        </tbody>
    </table>
</div>
<!-- ========================= fin historique ======================================= -->

</div> <!-- fin de container de la page --> 


<?php require_once '../../resources/includes/footer.php'; ?>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>

</body>
</html>