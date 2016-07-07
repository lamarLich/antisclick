$(document).ready(function(){
	$(":checkbox").click(function() {

		var checkedSite = $(this).attr('name');
		//alert(checkedSite);
		if($(this).prop('checked'))
			$('.'+checkedSite).css("display", "table-row");	
		else
			$('.'+checkedSite).css("display", "none");	
	});
});