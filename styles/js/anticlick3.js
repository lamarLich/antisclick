function setCookie(name, value, options) {
  options = options || {};

  var expires = options.expires;

  if (typeof expires == "number" && expires) {
    var d = new Date();
    d.setTime(d.getTime() + expires * 1000);
    expires = options.expires = d;
  }
  if (expires && expires.toUTCString) {
    options.expires = expires.toUTCString();
  }

  value = encodeURIComponent(value);

  var updatedCookie = name + "=" + value;

  for (var propName in options) {
    updatedCookie += "; " + propName;
    var propValue = options[propName];
    if (propValue !== true) {
      updatedCookie += "=" + propValue;
    }
  }

  document.cookie = updatedCookie;
}
function getCookie(name) {
    var cookie = " " + document.cookie;
    var search = " " + name + "=";
    var setStr = null;
    var offset = 0;
    var end = 0;
    if (cookie.length > 0) {
        offset = cookie.indexOf(search);
        if (offset != -1) {
            offset += search.length;
            end = cookie.indexOf(";", offset)
            if (end == -1) {
                end = cookie.length;
            }
            setStr = unescape(cookie.substring(offset, end));
        }
    }
    return(setStr);
}
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
	if (($_GET('utm_source') == 'google') || ($_GET('utm_source') == 'yandex') || ($_GET('gclid'))) {
            if(navigator['userAgent'].indexOf('Googlebot') == -1){           
                var data = '{"width": ' + screen['availWidth'] + ',"height": ' + screen['availHeight'] + ',"platform": "' + navigator['platform'] + '","userAgent": "' + navigator['userAgent'] + '","city": "' + ymaps.geolocation.city + '","region": "'+ymaps.geolocation.region+'","country": "' + ymaps.geolocation.country + '","utm":"'+ $_GET('utm_source') + '"}';
                $.ajax({
                    type: "POST",
                    url: "/checkIP",
                    data: { 'json': data },
                    success: function(response) {
                       setCookie("firstClick", "false");
                    }
                });
                setInterval(ImStillHere, 3000);
           }
		}
     else {
     	if(getCookie('firstClick') == 'false') {
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
