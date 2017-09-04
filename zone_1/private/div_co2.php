<?php    
    // Pour notre lib
    require_once('../vendor/autoload.php');

    // On crée un objet de type Repository.
    $obj_repo = new \GDS\Demo\Repository();
    // Chercher juste les dernières valeurs insérées.
    $arr_posts = $obj_repo->getLatestRecentPost();

?>
<html>
<head>
	<!-- script pour la courbe -->
    <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
	<!-- ********************** -->
</head>	
</html>
<div align="center">  
        <h4>Gaz carbonique</h4>
        <div id="co2" style="height: 400px; min-width: 310px"></div> <!-- div qui va contenir de la courbe -->
</div>

<!-- ===================== le script de la courbe lui même ================ -->

<!-- tout d'abord on cherche les valeurs -->
<?php
foreach($arr_posts as $obj_post)
        {
            // val ppm
            $ppm_co2 = $obj_post->co2; 
        }
?> 
                                  }
<script type="text/javascript">
   $(document).ready(function () {
    Highcharts.setOptions({
        global: {
            useUTC: false
        }
    });

    Highcharts.chart('co2', {
        chart: {
            type: 'spline',
            animation: Highcharts.svg, // Ne pas animer dans l'ancien IE
            marginRight: 10,
            events: {
                load: function () {

                    // Configurer la mise à jour du graphique chaque 4 seconde
                    var series = this.series[0];
                    setInterval(function () {
                        var x = (new Date()).getTime(), // heure actuelle
                            y = <?php echo $ppm_co2 ;?>; // les valeurs en ppm sur l'axe des ordonnées
                        series.addPoint([x, y], true, true);
                    }, 4000);
                }
            }
        },
        title: {
            text: 'Live CO2 data'
        },
        xAxis: {
            type: 'datetime',
            tickPixelInterval: 150
        },
        yAxis: {
            title: {
                text: 'Value in ppm'
            },
            plotLines: [{
                value: 0,
                width: 1,
                color: '#808080'
            }]
        },
        tooltip: {
            formatter: function () {
                return '<b>' + this.series.name + '</b><br/>' +
                    Highcharts.dateFormat('%Y-%m-%d %H:%M:%S', this.x) + '<br/>' +
                    Highcharts.numberFormat(this.y, 2);
            }
        },
        legend: {
            enabled: false
        },
        exporting: {
            enabled: false
        },
        series: [{
            name: 'co2',
            data: (function () {
                var data = [],
                    time = (new Date()).getTime(),
                    i;

                for (i = -19; i <= 0; i += 1) {
                    data.push({
                        x: time + i * 1000,
                        y: <?php echo $ppm_co2 ;?>; // les valeurs en ppm sur l'axe des ordonnées
                    });
                }
                return data;
            }())
        }]
    });
});
</script>
<!-- ================================================================ -->