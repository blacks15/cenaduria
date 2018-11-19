sidebar = {
    var: {
        menu_visible: 0
    },
};

$(document).on('click', '.navbar-toggle', function () {
    $toggle = $(this);

    if (sidebar.var.menu_visible == 1) {
        sidebar.var.menu_visible = 0;

        setTimeout(function () {
            $toggle.removeClass('toggled');
            $('#bodyClick').remove();
        }, 550);
    } else {
        setTimeout(function () {
            $toggle.addClass('toggled');
        }, 580);

        div = '<div id="bodyClick"></div>';
        $(div).appendTo('body').click(function () {
            $('html').removeClass('nav-open');
            sidebar.var.menu_visible = 0;

            setTimeout(function () {
                $toggle.removeClass('toggled');
                $('#bodyClick').remove();
            }, 550);
        });

        $('html').addClass('nav-open');
        sidebar.var.menu_visible = 1;

        $toggle.removeClass('toggled');

        setTimeout(function () {
            $('.sidebar').addClass('transition:', 'all 0.1s cubic-bezier(0.685, 0.0473, 0.346, 1);');
            $('.sidebar').addClass('-webkit-transition:', 'all 0.1s cubic-bezier(0.685, 0.0473, 0.346, 1);');
        }, 550);
    }
});