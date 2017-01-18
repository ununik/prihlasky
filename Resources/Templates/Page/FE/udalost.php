<?php
$container = '<h2>'.$udalost['title'].'</h2>';

$container .= '<table>';

$container .= '<tr>';
$container .= '<td>';
$container .= 'Datum';
$container .= '</td>';
$container .= '<td>';
$container .= date($GLOBALS['webInfo']['date_format'], $udalost['udalost_timestamp']);
$container .= '</td>';
$container .= '</tr>';

if ($udalost['prezentace_gps_N'] != 0 && $udalost['prezentace_gps_N'] != 0) {
    $container .= '<tr>';
    $container .= '<td>';
    $container .= 'Prezentace';
    $container .= '</td>';
    $container .= '<td>';
    $container .= "{$udalost['prezentace_gps_N']}N, {$udalost['prezentace_gps_E']}E";
    $container .= '<div id="mapPrezentace" style="width: 200px; height: 100px;"></div>';
    $container .= '</td>';
    $container .= '</tr>';
}

if ($udalost['start_gps_N'] != 0 && $udalost['start_gps_N'] != 0) {
    $container .= '<tr>';
    $container .= '<td>';
    $container .= 'Start';
    $container .= '</td>';
    $container .= '<td>';
    $container .= "{$udalost['start_gps_N']}N, {$udalost['start_gps_E']}E";
    $container .= '<div id="mapStart" style="width: 200px; height: 100px;"></div>';
    $container .= '</td>';
    $container .= '</tr>';
}

if ($udalost['cil_gps_N'] != 0 && $udalost['cil_gps_N'] != 0) {
    $container .= '<tr>';
    $container .= '<td>';
    $container .= 'Cíl';
    $container .= '</td>';
    $container .= '<td>';
    $container .= "{$udalost['cil_gps_N']}N, {$udalost['cil_gps_E']}E";
    $container .= '<div id="mapCil" style="width: 200px; height: 100px;"></div>';
    $container .= '</td>';
    $container .= '</tr>';
}

$container .= '</table>';

$container .= '<script>
    function initMap() {
        var uluru = {lat: '.$udalost['prezentace_gps_N'].', lng: '.$udalost['prezentace_gps_E'].'};
        var map = new google.maps.Map(document.getElementById(\'mapPrezentace\'), {
            zoom: 18,
            center: uluru
        });
        var marker = new google.maps.Marker({
            position: uluru,
            map: map
        });
                
        var uluru = {lat: '.$udalost['start_gps_N'].', lng: '.$udalost['start_gps_E'].'};
        var map = new google.maps.Map(document.getElementById(\'mapStart\'), {
            zoom: 18,
            center: uluru
        });
        var marker = new google.maps.Marker({
            position: uluru,
            map: map
        });
                
        var uluru = {lat: '.$udalost['cil_gps_N'].', lng: '.$udalost['cil_gps_E'].'};
        var map = new google.maps.Map(document.getElementById(\'mapCil\'), {
            zoom: 18,
            center: uluru
        });
        var marker = new google.maps.Marker({
            position: uluru,
            map: map
        });
    }
</script>
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAHLZgqLKYOmNqVe0RGg2i9hALvnrWrBU4&callback=initMap"></script>';

return $container;