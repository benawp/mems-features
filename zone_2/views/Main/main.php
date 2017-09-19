<?php
require_once '../../resources/configs/calcul-masse-molaire.php';
require_once '../../controllers/Main/getSession.php';
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <title>SDPE - IoT Welcome</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css">
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/css/demo.css">
    <meta name="author" content="Yvon Benahita">
    <link rel="icon" type="image/png" href="/img/datastore-logo.png" />

    <!-- font awesome -->
    <link rel="stylesheet" href="css/font-awesome/font-awesome.css">
    
    <!-- Pour le Jauge  -->
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <!-- Fin -->

    <!-- jquery du rafraîchissement -->
    <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
</head>
<!-- end head -->

<body>
      <?php require_once '../../resources/includes/header-main.php'; ?>
        
        <div class="container" id="contenu_main"><!-- ========= Pour tout le contenu de notre site======== -->

            <!-- =========================== Le logo et le titre ============================ -->
            <div class="row">
                <div class="col-md-12">
                    <h1><img src="/img/datastore-logo.png" id="gds-logo" /> PHP & <span class="hidden-xs">Google</span> Cloud Datastore</h1>
                </div>
            </div>
            <!-- ====================================================================== -->

            <!-- ==================== La définition et le Dashboard ===================== -->
            <div class="row">
                <!-- Définition -->
                <div class="col-md-8">
                    <h2><i class="fa fa-info" style="margin-left: 3px;margin-right: 4px;" aria-hidden="true"></i>
                        What is it ?</h2>
                    <dd>Etes vous stricte à l’air que vous respirez ? Il est important pour vous de savoir le taux des polluants vous entour pour respirer tranquille ? Ce site et le système que nous avons conçue est faite pour vous. 
                    Ici vous pouvez visualisez en temps réelle et même recevoir des notifications lorsque le taux des polluants dépasse leur seuil acceptable.
                    En plus, ce sont les trois polluants qui sont très répandu et dangereux voire mortel que notre système détecte pour vous alerter et vous pouvez prendre une décision appropriée. Ce sont premièrement le dioxyde de carbone ou gaz carbonique provenant du secteur des transports de l’industrie, de l’habitat et aussi lors de la respiration des animaux et de la photosynthèse des végétaux. Ensuite le monoxyde de carbone issu de la combustion incomplète des combustibles et des carburants (la combustion complète produisant du CO2). Et enfin l’ammoniaque qui provient de rejets organiques de l’élevage, épandage de fertilisants.
                    </dd>
                </div>
                <!-- Dadhboard -->
                <div class="col-md-4" >
                    <h3 align="center"><i class="fa fa-tachometer" style="margin-right: 4px;" aria-hidden="true"></i>
                    Counter Of Gases not acceptable</h3>

                    <div id="chart_div" style="width: 400px; height: 120px;margin:auto;">
                    
                     <?php 
                     // Appelle controlleur
                     require_once '../../controllers/Main/getPourcNotAcceptable.php';  

                     // Tant que les données ne sont pas prêtes on affiche un loder                        
                     if($res[0] == null AND $res[1] == null AND $res[2]== null)
                     {
                        ?>
                         <p>En attente des <strong>données</strong> provenant des <strong>capteurs</strong>...</p>
                         <div class="loader_compteurs"></div>
                        <?php
                     }
                        ?>
                    <!-- fin affichage loader -->

                    <!-- afficher les pourcentages de gazs non acceptable sur les compteurs -->
                    <script type="text/javascript">
                    google.charts.load('current', {'packages':['gauge']});
                    google.charts.setOnLoadCallback(drawChart);

                                function drawChart() 
                                {
                                    // des valeurs aléatoires au chargement de la page
                                    var data = google.visualization.arrayToDataTable([
                                      ['Label', 'Value'],                             
                                      ['CO2', <?php echo rand(0, 100); ?>],
                                      ['CO', <?php echo rand(0, 100); ?>],
                                      ['NH3', <?php echo rand(0, 100); ?>]
                                    ]);

                                    var options = {
                                      width: 400, height: 120,
                                      redFrom: 90, redTo: 100,
                                      yellowFrom:75, yellowTo: 90,
                                      minorTicks: 10
                                    };

                                    var chart = new google.visualization.Gauge(document.getElementById('chart_div'));

                                    chart.draw(data, options);

                                    setInterval(function() {
                                      data.setValue(0, 1, 0 + <?php echo htmlspecialchars($res[0]); ?>);
                                      chart.draw(data, options);
                                    }, 4000);
                                    setInterval(function() {
                                      data.setValue(1, 1, 0 + <?php echo htmlspecialchars($res[1]); ?>);
                                      chart.draw(data, options);
                                    }, 4000);
                                    setInterval(function() {
                                      data.setValue(2, 1, 0 + <?php echo htmlspecialchars($res[2]); ?>);
                                      chart.draw(data, options);
                                    }, 4000);
                                }                    
                    </script>
                    <!-- ================= Fin script affich ===================== % -->

                    </div> <!-- fin div compteurs -->
                </div> <!-- fin col md 4 -->
            </div> <!-- fin row -->
        <!-- ========================================================================== -->
        <br>
		<hr style="width: 50%; border-top: 1px solid #cacaca;">
        <!-- ============================== Le Map ==================================== -->
            <div>
                <h2><i class="fa fa-map-marker" style="margin-right: 4px;margin-left: 3px;" aria-hidden="true"></i>
                        Where are our sensors?</h2>
                        <dd>C'est l'endroit où est installé le capteur en ce moment même.</dd>
                <div class="my_map">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3774.373973254404!2d47.529468015323786!3d-18.914833987180533!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x21f07de34d65ea03%3A0xea472922cda706d5!2sTunnel+Ambanidia%2C+Antananarivo%2C+Madagascar!5e0!3m2!1sfr!2sfr!4v1505731330036" width="675" height="250" frameborder="0" style="border:0" allowfullscreen></iframe>
                </div>
            </div>
        <!-- =============================== Fin Map ================================== -->
<br><br>
<hr style="width: 50%; border-top: 1px solid #cacaca;">
<!-- ========================== Tableau des dernièrs valeurs en mg/m3 ========================== -->
<h2><i class="fa fa-bell" style="margin-left: 3px;margin-right: 4px;" aria-hidden="true"></i>
Notifications</h2>
<dd>Les valeurs ci-desous(dans le cas où elles existent)sont en milligramme par mètre cube. On l'obtient multipliant le poid moléculaire en gramme du polluant par sa valeur en partie par million retournée par le capteur et en divisant le résultat par le volume molaire d'un gaz à temperature et pression ambiantes normales.</dd>
<div class="brute" id="mg_m3" style="height: 420px;">

    <?php 
        // Appelle controlleur
        require_once '../../controllers/Main/getValueInMgM3.php'; 
    ?>

   <div class="promos">  
        <div class="promo">
          <div class="deal">
            <span style="padding-bottom: 15px;padding-top: 5px;">CO2</span>
            <span>Quantité de dioxyde de carbone</span>
          </div>
          <span class="price" style="background-color: <?php
                                                            require_once '../../resources/includes/mg_m3-bg-co2.php';
                                                        ?>"><?php 
                                                        if(isset($masseVolumique_co2)) echo htmlspecialchars($masseVolumique_co2)." ".'<em>mg/m3</em>'; 
                                                        else 
                                                            {
                                                                ?>
                                                                <div class="loader_notif_co2_nh3"></div>
                                                                <?php
                                                            }
                                                        ?></span>
          <ul class="features">
            <li class="li_brute">Naturellement produit par tous les organismes</li>
            <li class="li_brute">lors de la respiration des animaux</li>
            <li class="li_brute">et de la photosynthèse des végétaux.</li>   
          </ul>
          <a href="<?php 
                                    require '../../resources/includes/href-home-or-login.php';
                                ?>"><button type="submit" class="btn btn-primary sign_up">See More
                    </button></a>
        </div>
        <div class="promo scale">
          <div class="deal">
            <span style="padding-bottom: 15px;padding-top: 5px;">CO</span>
            <span>Lorem ipsum lorem ipsum</span>
          </div>
          <span class="price" style="background-color: <?php
                                                          require_once '../../resources/includes/mg_m3-bg-co.php';                                                            
                                                        ?>"><?php 
                                                        if(isset($masseVolumique_co)) 
                                                            echo htmlspecialchars($masseVolumique_co)." ".'<em>mg/m3</em>';
                                                        else 
                                                        {
                                                            ?>
                                                                <div class="loader_notif_co"></div>
                                                            <?php
                                                        }
                                                        ?></span>
          <ul class="features">
            <li class="li_brute">Issu de la combustion incomplète</li>
            <li class="li_brute">d'un combustible carboné comme</li>
            <li class="li_brute">le bois, le charbon, les chauffages.</li>   
          </ul>
          <a href="<?php 
                                    require '../../resources/includes/href-home-or-login.php';
                                ?>"><button type="submit" class="btn btn-primary sign_up">See More
                   </button></a>
        </div>
        <div class="promo">
          <div class= "deal">
            <span style="padding-bottom: 15px;padding-top: 5px;">NH3</span>
            <span>L'ammoniaque</span>
          </div>
          <span class="price" style="background-color: <?php
                                                          require_once '../../resources/includes/mg_m3-bg-nh3.php';
                                                       ?>"><?php 
                                                        if(isset($masseVolumique_nh3)) 
                                                            echo htmlspecialchars($masseVolumique_nh3)." ".'<em>mg/m3</em>'; 
                                                        else 
                                                           {
                                                                ?>
                                                                <div class="loader_notif_co2_nh3"></div>
                                                                <?php
                                                           }
                                                        ?></span>
          <ul class="features">
            <li class="li_brute">Issu de la fermentation</li>
            <li class="li_brute">de la décomposition des substances organiques</li>
            <li class="li_brute">par des microorganismes en milieu anaérobie.</li>   
          </ul>
          <a href="<?php 
                                    require '../../resources/includes/href-home-or-login.php';
                                ?>"><button type="submit" class="btn btn-primary sign_up">See More
                   </button></a>
        </div> 
    </div> 
</div> <!-- end notiff mg/m3 -->

<div style="margin-right: 80px;"> <!-- Legend -->

    <script>
        // On attend que la page soit chargée 
        jQuery(document).ready(function()
        {
        // On cache la zone de texte
        jQuery('#toggle').hide();
        // toggle() lorsque le lien avec l'ID #toggler est cliqué
        jQuery('h2#toggler_legend').click(function()
        {
        jQuery('#toggle').toggle(400);
        return false;
        });
        });
    </script>

    <h2 id="toggler_legend"><i class="fa fa-bookmark" style="margin-right: 4px;margin-left: 3px;" aria-hidden="true"></i>See The Legend</h2>

    <div id="toggle">   
            <div class="float">
            <div class="carre" style="background-color:#beeb9f;display: inline;"></div> <p style="color: #212121" class="fanazavana">Vous trouvez dans un endroit très aéré ! Vous pouvez être tranquille.</p>
            </div>
        <br>
            <div class="float" style="margin-top: 0px;
                                      margin-right: 400px;">
            <div class="carre" style="background-color:#e67e22;display: inline;"></div> <p style="color: #e67e22" class="fanazavana">L'endroit est PRESQUE invivable à cause des polluants ! Prenez bien garde !!</p>
            </div>
        <br>
            <div class="float">
            <div class="carre" style="background-color:#e74c3c;display: inline;"></div> <p style="color: #e74c3c" class="fanazavana">Alerte ! Alerte ! Vous devez aérez le lieu ou bien évacuez !! Ça devient invivable.</p>
            </div>
    </div>
 </div> <!-- end legend <--><br>

<!-- ========================== fin Tab Dèr=============================== -->

 <!-- ========================== Espace connexion ============================== -->
            
  <h2 style="margin-top: 100px;"><i class="fa fa-plus" style="margin-right: 4px;margin-left: 3px;" aria-hidden="true"></i>
  See more content</h2>
            
            <div class="row">
                <div class="col-md-4" id="login_btn">
                    <div class="well btn_main_connect">
                        <form method="POST" action="<?php if(isset($user)) {echo '/home';} else {echo '/login';} ?>">
                            <button type="submit" class="btn btn-primary" align="center" style="margin-left: -30px;">
                                <?php 
                                    if(isset($user)) 
                                        {echo "Go Home<i class='fa fa-arrow-right' style='margin-left: 15px;'></i>";}
                                    else 
                                        {echo "Se Connecter";}
                                ?>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        <!-- ====================== Fin Espace Connexion ============================== -->

</div> <!-- fin de container de la page --> 
       
<?php require_once '../../resources/includes/footer.php'; ?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>
   
</body>
</html>