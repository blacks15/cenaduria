$(document).ready(function () {
    initialComponent();

    $("#btnPaso2").on('click', function () {
        global.cambiarTab('profile-tab', 'address-tab', '49.494616', 'address');
    });

    $("#btnAnt").on('click', function () {
        global.cambiarTab('address-tab', 'profile-tab', '16.161616', 'profile');
    });

    $("#btnPaso3").on('click', function () {
        global.cambiarTab('address-tab', 'contact-tab', '82.827616', 'contact');
    });

    $("#btnAnt2").on('click', function () {
        global.cambiarTab('contact-tab', 'address-tab', '49.494616', 'address');
    });

    $("#btnSave").on('click', function () {
        $(".progress-bar").css('width', '100%');
        $(".nav-link").removeClass('active');
    });

    $("#cp").on('focusout', function () {

    });

    function initialComponent(){
        global.initialSelect('selectpicker');
        global.initialCalendar('fechaNac');
        global.initialTooltip("data-toggle");
    }
});