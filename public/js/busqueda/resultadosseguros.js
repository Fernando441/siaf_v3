"use strict";
var Modulo = function() {

    var initEvents = function() {
        $( "#btnExcel" ).click(function( e ) {
            e.preventDefault();
            let unidades_total = $('#unidades_total').val();
            if (unidades_total > 0) {
                $('#formseguros').submit();
            }
        });
    };

    return {

        //main function to initiate the module
        init: function() {
            initEvents();
        },
    };
}();

jQuery(document).ready(function() {
    Modulo.init();
});

