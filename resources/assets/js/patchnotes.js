$(document).ready(function() {

    $('.project-header').textfill({
        maxFontPixels: 26
    });


    $('[data-toggle="tooltip"]').tooltip();


    $('.social-code').click(function(e) {
        e.preventDefault();

        $("#code").slideToggle();
    });

    $('body').on('click', '.social-subscribe', function(e) {
        e.preventDefault();

        var self = this;
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

                $('#unsubscribe').slideUp();
                $('#subscribe').slideDown();
                $icon.removeClass().addClass('fa fa-minus');
                $(self).removeClass('social-subscribe').addClass('social-unsubscribe');
            });
    });

    $('body').on('click', '.social-unsubscribe', function(e) {
        e.preventDefault();

        var self = this;
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

                $('#subscribe').slideUp();
                $('#unsubscribe').slideDown();
                $icon.removeClass().addClass('fa fa-plus');
                $(self).removeClass('social-unsubscribe').addClass('social-subscribe');
            });
    });

});
