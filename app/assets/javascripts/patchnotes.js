$(document).ready(function() {

    $('.textfill').textfill();


    $('[data-toggle="tooltip"]').tooltip();


	$('.social-code').click(function(e) {
		e.preventDefault(); 

		$("#code").slideToggle();
	});

	$('.social-subscribe').click(function(e) {
		e.preventDefault();

		$('#subscribe').slideToggle();
	});

});