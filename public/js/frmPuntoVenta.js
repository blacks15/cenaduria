$(document).ready(function () {
    initialComponent();

    function initialComponent(){
        global.initialSelect('selectpicker');
        global.initialTooltip("data-toggle");
    
        $("#txtCodigoBuscar").focus();
    }
});