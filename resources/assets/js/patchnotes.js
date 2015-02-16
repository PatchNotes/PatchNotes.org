$(document).ready(function() {

    // create social networking pop-ups
    (function() {
        // link selector and pop-up window size
        var Config = {
            Link: "a.share",
            Width: 500,
            Height: 500
        };

        // add handler links
        $(Config.Link).on('click', PopupHandler);

        // create popup
        function PopupHandler(e) {

            e = (e ? e : window.event);
            var t = (e.target ? e.target : e.srcElement);

            // popup position
            var
                px = Math.floor(((screen.availWidth || 1024) - Config.Width) / 2),
                py = Math.floor(((screen.availHeight || 700) - Config.Height) / 2);

            // open popup
            var popup = window.open(t.href, "social",
                "width="+Config.Width+",height="+Config.Height+
                ",left="+px+",top="+py+
                ",location=0,menubar=0,toolbar=0,status=0,scrollbars=1,resizable=1");
            if (popup) {
                popup.focus();
                if (e.preventDefault) e.preventDefault();
                e.returnValue = false;
            }

            return !!popup;
        }

    }());

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
            data: {
                _token: $(this).attr('data-csrf-token')
            },
            type: "POST"
        }).done(function(response) {


                $('#unsubscribe').slideUp();
                $('#subscribe').slideDown();
                $icon.removeClass().addClass('fa fa-minus');
                $(self).removeClass('social-subscribe').addClass('social-unsubscribe');
            }).error(function(response) {
            if(response.success == false) {
                alert(response.error);

                $icon.removeClass().addClass('fa fa-plus');

                return;
            }
        });
    });

    $('body').on('click', '.social-unsubscribe', function(e) {
        e.preventDefault();

        var self = this;
        var $icon = $(this).children('i');
        $icon.removeClass().addClass('fa fa-cog fa-spin');

        $.ajax({
            url: $(this).attr('href'),
            data: {
                _token: $(this).attr('data-csrf-token')
            },
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
