jQuery(document).ready(function () {
    jQuery(".delete").on("click", function (e) {
        e.preventDefault();
        swal({
            title: "¿Estás seguro de dar de baja este registro?",
            text: "Esta operación dará de baja este registro permanentemente",
            icon: "warning",
            buttons: true,
            buttons: ["Cancelar", "Aceptar"],
            dangerMode: true,
        }).then((willDelete) => {
            if (willDelete) {
                jQuery(this).parent().submit();
            }
        });
    });

    jQuery(".editado").on("click", function (e) {
        e.preventDefault();
        swal({
            title: "¿Estás seguro de marcar este reporte como Revisado?",
            text: "Esta operación marcará este reporte como Revisado",
            icon: "warning",
            buttons: true,
            buttons: ["Cancelar", "Aceptar"],
            dangerMode: true,
        }).then((willEdit) => {
            if (willEdit) {
                jQuery(this).parent().submit();
            }
        });
    });
});