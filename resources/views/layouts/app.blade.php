<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/87ebfbc54f.js" crossorigin="anonymous"></script>

    @stack('css')
</head>

<body style="min-height: 100vh">
    <div class="row p-0 m-0" style="min-height: 100vh">
        <div class="col-2 p-0 m-0">
            @include('layouts.navigation')
        </div>

        <!-- Page Heading -->
        <div class="col-10 p-0 m-0">
            @isset($header)
                <header>
                    <div class="p-2">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main class="p-2">
                {{ $slot }}
            </main>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
    @stack('js')


    <script>
        let table = new DataTable('#tabla-traducida', {
            language: {
                processing: "Procesando...",
                search: "Buscar:",
                lengthMenu: "Mostrar _MENU_ registros",
                info: "Mostrando _START_ a _END_ de _TOTAL_ registros",
                infoEmpty: "Mostrando 0 a 0 de 0 registros",
                infoFiltered: "(filtrado de _MAX_ registros en total)",
                infoPostFix: "",
                loadingRecords: "Cargando...",
                zeroRecords: "No se encontraron resultados",
                emptyTable: "No hay datos disponibles en la tabla",
                paginate: {
                    first: '<i class="fa-solid fa-angles-left"></i>',
                    next: '<i class="fa-solid fa-chevron-right"></i>',
                    previous: '<i class="fa-solid fa-angle-left"></i>',
                    last: '<i class="fa-solid fa-angles-right"></i>'
                },
                aria: {
                    sortAscending: ": Activar para ordenar la columna en orden ascendente",
                    sortDescending: ": Activar para ordenar la columna en orden descendente"
                }
            },
            dom: "<'d-flex justify-content-between align-items-center p-2'<'d-flex'><'d-flex'f>>" +
                "<'table-responsive'tr>" +
                "<'d-flex justify-content-between p-2'i p>",
        });
    </script>

</body>

</html>
