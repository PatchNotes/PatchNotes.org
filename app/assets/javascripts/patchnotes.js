$(document).ready(function() {

    $('.textfill').textfill();


    $('[data-toggle="tooltip"]').tooltip();


	$('.social-code').click(function(e) {
		e.preventDefault(); 

		$("#code").slideToggle();
	});

	$('body').on('click', '.social-subscribe', function(e) {
		e.preventDefault();

        var $icon = $(this).children('i');
        $icon.removeClass().addClass('fa fa-cog fa-spin');

        $.ajax({
            url: $(this).attr('href'),
            type: "POST"
        }).done(function(response) {
                if(response.success == false) {
                    alert(response.error);

                    $icon.removeClass().addClass('fa fa-plus');

                    return;
                }

                $('#subscribe').slideToggle();
                $icon.removeClass().addClass('fa fa-minus');
                $(this).removeClass('social-subscribe').addClass('social-unsubscribe');
            });
	});

    $('body').on('click', '.social-unsubscribe', function(e) {
        e.preventDefault();

        var $icon = $(this).children('i');
        $icon.removeClass().addClass('fa fa-cog fa-spin');

        $.ajax({
            url: $(this).attr('href'),
            type: "DELETE"
        }).done(function(response) {
                if(response.success == false) {
                    alert(response.error);

                    $icon.removeClass().addClass('fa fa-minus');

                    return;
                }

                $('#subscribe').slideToggle();
                $icon.removeClass().addClass('fa fa-plus');
                $(this).removeClass('social-unsubscribe').addClass('social-subscribe');
            });
    });


});
