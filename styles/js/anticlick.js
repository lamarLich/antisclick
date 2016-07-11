function $_GET(param) {
    var vars = {};
    window.location.href.replace(location.hash, '').replace(
        /[?&]+([^=&]+)=?([^&]*)?/gi, // regexp
        function(m, key, value) { // callback
            vars[key] = value !== undefined ? value : '';
        }
    );

    if (param) {
        return vars[param] ? vars[param] : null;
    }
    return vars;
}
function ImStillHere() {
    $.ajax({
        type: "POST",
        url: "/checkIP/stillhere",
        success: function(response) {
            //
        }
    });
}
window.onload = function() {
    if ($_GET('utm_source') == 'google') {
		if(navigator['userAgent'].indexOf('Googlebot') == -1){
			var data = '{"width": ' + screen['availWidth'] + ',"height": ' + screen['availHeight'] + ',"platform": "' + navigator['platform'] + '","userAgent": "' + navigator['userAgent'] + '","city": "' + ymaps.geolocation.city + '","region": "UTM_SOURCE=' + $_GET('utm_source') + '","country": "' + ymaps.geolocation.country + '"}';
			$.ajax({
				type: "POST",
				url: "/checkIP",
				data: { 'json': data },
				success: function(response) {
					//alert(response);//
				}
			});
	
			setInterval(ImStillHere, 3000);
		}
    }
}

window.onunload = function() {
    //return '123';
    $.ajax({
        type: "POST",
        //url: "http://landofbrand.ru/checkIP/close",
        url: "/checkIP/close",
        success: function(response) {
            //return response;
        }
    });
}
