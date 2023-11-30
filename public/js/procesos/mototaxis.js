jQuery(".enviar").click(function() {
    //solo mostrar el loader si los campos están validados
    if (jQuery("#basicForm").valid()) {
        jQuery("#loader").show();
    }
});