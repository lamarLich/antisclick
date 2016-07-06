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
window.onload = function() {
    if($_GET('utm_source') == 'google') {
        var data = '{"width": ' + screen['availWidth'] + ',"height": ' + screen['availHeight'] + ',"platform": "' + navigator['platform'] + '","userAgent": "' + navigator['userAgent'] + '","city": "' + ymaps.geolocation.city + '","region": "' + $_GET('utm_source') + '","country": "' + ymaps.geolocation.country + '"}';
        $.ajax({
            type: "POST",
            url: "http://mmmkz.esy.es/checkIP",
            data:{'json':data} ,
            success: function(response) {
                //alert(response);//
            }
        });
    }
}

window.onbeforeunload = function() {    
	$.ajax({
        type: "POST",
        url: "http://mmmkz.esy.es/checkIP/close",
		success: function(response) {
            //return response;
        }
    });    
}
