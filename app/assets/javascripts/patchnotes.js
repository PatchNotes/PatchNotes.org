$(document).ready(function() {

	$('[data-toggle="tooltip"]').tooltip();


	$('.social-code').click(function(e) {
		e.preventDefault(); 

		$("#code").slideToggle();
	});

});
