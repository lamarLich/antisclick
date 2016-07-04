<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="utf-8">
	<title><?php echo $title ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap -->
    <link href="/styles/css/bootstrap.min.css" rel="stylesheet">
    <script src="http://api-maps.yandex.ru/2.0-stable/?load=package.standard&lang=ru-RU" type="text/javascript"></script>
	<script src="http://yastatic.net/jquery/2.1.1/jquery.min.js"></script>
	<script type="text/javascript"> 
window.onload = function () {   
    var data = '{"width": ' + screen['availWidth'] +',"height": ' + screen['availHeight'] +',"platform": "' + navigator['plarform'] +'","userAgent": "' + navigator['userAgent'] +'","city": "' + ymaps.geolocation.city +'","region": "' + ymaps.geolocation.region +'","country": "' + ymaps.geolocation.country +'"}';

   $.ajax({
    type: "POST",
    url: "http://localhost/CheckIP",
    data: data,
    success: function(response){
     alert(response);
   	}
 	});
}
</script>

</head>
<body>

<div id="container">
	<div class="row">
            