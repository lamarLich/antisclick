$(document).ready(function(){
	//выбор сайта для отбржени кликов по нему
	$(":checkbox").click(function() {

		var checkedSite = $(this).attr('name');
		//alert(checkedSite);
		if($(this).prop('checked'))
			$('.'+checkedSite).css("display", "table-row");	
		else
			$('.'+checkedSite).css("display", "none");	
	});

$('tr.site-row').each(function() {
	var Id = $(this).attr('id');
$.ajax({
			type: 'GET',
			url: '/panel/GetCitysFromSiteID',
			data: {id: Id},
			success: function(response) {
				var jsonObj = eval('(' + response + ')');	
				for (var i = 0; i < jsonObj.length; i++) {					
					var ii = i + 1;
					$('#' + Id + '.regions').html( $('#' + Id + '.regions').html() + ' ' + jsonObj[i].name);	
				};								
			}
		});
});

	//привзяка регионов к сайту
	$('.but').click(function() {
		var site = $(this).attr('id');
		var cityIds = new Array();
		if ($('select#' + site + ' option:selected').val() == 0) {
			return;
		}
		$('select#' + site + ' option:selected').each(function() {
			if ($(this).val() == 0) {
				
				return;
			}
			cityIds.push($(this).val());
		});
		var data = {
			name: site,
			cities: cityIds
		};
		$.ajax({
			type: 'POST',
			url: '/panel/AddRegion',
			data: { 'json': JSON.stringify(data) },
			success: function(response) {
				//
			}
		});		
	});
});
	