@if(session()->has('message'))
    @if(session()->has('status') && !session()->get('status'))
        <script>
            swal({
                icon: "warning",
                title: "Advertencia",
                text: "{{ session()->get('message') }}",
                confirm: true,
                closeOnClickOutside: false,
                closeOnEsc: false,
                button: {
                    text: "OK",
                    value: true,
                    visible: true,
                    className: "btn-danger", // Cambia el color de fondo del botón a rojo en tema claro
                }
            }).then((isConfirm) => {
                if(isConfirm){
                    location.reload();
                }
            });
        </script>
    @elseif(session()->has('status') && session()->get('status'))
        <script>
            swal({
                icon: "success",
                title: "Éxito",
                text: "{{ session()->get('message') }}",
                confirm: true,
                closeOnClickOutside: false,
                closeOnEsc: false,
                button: {
                    text: "OK",
                    value: true,
                    visible: true,
                    className: "btn-success", // Cambia el color de fondo del botón a verde en tema claro
                }
            }).then((isConfirm) => {
                if(isConfirm){
                    location.reload();
                }
            });
        </script>
    @endif
@endif
