$(document).ready(function() {

    $('.textfill').textfill();


    $('[data-toggle="tooltip"]').tooltip();


	$('.social-code').click(function(e) {
		e.preventDefault(); 

		$("#code").slideToggle();
	});

	$('.social-subscribe').click(function(e) {
		e.preventDefault();

        $.ajax({
            url: $(this).attr('href'),
            type: "POST"
        }).done(function(response) {
                if(response.success == false) {
                    alert(response.error);
                    return;
                }

                $('#subscribe').slideToggle();
            });


	});

});