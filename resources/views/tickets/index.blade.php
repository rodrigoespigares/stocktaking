<x-app-layout>
    @push('css')
        <link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.dataTables.css" />
        <link rel="stylesheet" href="{{asset('css/tail.select.css')}}">
    @endpush
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tickets') }}
        </h2>
    </x-slot>

    <div class="card">
        <div class="d-flex justify-content-between align-items-center p-2">
            <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('home')}}">Inicio</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Tickets</li>
                </ol>
            </nav>
            <div class="d-flex gap-3">
                <button class="btn btn-success" onclick="total()">Total Día</button>
                <button class="btn btn-primary" onclick="crear()">Hacer ticket</button>
            </div>
        </div>
        <table id="tabla-traducida" class="display">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Fecha</th>
                    <th>Total</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($tickets as $ticket)
                    <tr>
                        <td>{{ $ticket->id }}</td>
                        <td>{{ $ticket->created_at }}</td>
                        <td>{{ $ticket->total }}</td>
                        <td class="d-flex gap-3">
                            <button onclick="verDetalle('{{$ticket->id}}')" class="btn btn-secondary">Ver</button>
                            <button class="btn btn-warning">Imprimir</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Modal para crear ticket -->
    <div class="modal fade" id="crear" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="crear" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="modal-title fs-5" id="crear">Hacer ticket</h2>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('productos.store') }}" method="POST">
                        @csrf
                        <input type="hidden" id="id" name="id" value="">
                        <div class="mb-5">
                            <label class="block text-sm font-medium text-gray-700">Referencia</label>
                            <select name="referencia" id="referencia" class="block w-full border rounded-md tailselect" required>
                                <option selected disabled hidden value="">Selecciona un producto</option>
                                @foreach ($productos as $producto)
                                    <option value="{{ $producto->referencia }}">{{ $producto->referencia }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-4">
                            <label for="cantidad" class="block text-sm font-medium text-gray-700">Cantidad</label>
                            <input min="0" id="cantidad" type="number" name="cantidad" class="block w-full border rounded-md" required>
                        </div>

                        {{-- Cuando das click en agregar, se agrega el producto a la tabla de productos agregados pero se debe buscar por la referencia --}}
                        <div class="mb-4">
                            <button type="button" class="btn btn-success" onclick="agregarProducto()">Agregar</button>
                        </div>

                        {{-- Listado de productos agregados por ajax--}}
                        <div class="mb-4 w-100">
                            <table id="tabla-agregados" class="display">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Referencia</th>
                                        <th>Nombre</th>
                                        <th>Precio Público</th>
                                        <th>Cantidad</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    
                                </tbody>
                            </table>
                        </div>
            
                        <div class="mt-5 flex justify-end gap-3">
                            <button onclick="deleteTicket()" type="button" class="btn btn-secondary" data-bs-dismiss="modal" aria-label="Close">
                                Cancelar
                            </button>
                            <button type="submit" class="btn btn-primary">
                                Imprimir
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para mostrar total del día -->
    <div class="modal fade" id="total" tabindex="-1" aria-labelledby="total" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="modal-title fs-5" id="total">Total del día</h2>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Total del día</label>
                        <input id="total-input" type="text" name="total" class="block w-full border rounded-md" required readonly>€
                    </div>
                </div>
            </div>
        </div>
    </div>





    @push('js')
        <script src="https://code.jquery.com/jquery-3.7.1.slim.js" integrity="sha256-UgvvN8vBkgO0luPSUl2s8TIlOSYRoGFAX4jlCIm9Adc=" crossorigin="anonymous"></script>
        <script src="https://cdn.datatables.net/2.2.2/js/dataTables.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/tail.select.js@1.1.0/js/tail.select.min.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                tail.select('.tailselect', {
                    placeholder: 'Selecciona un producto',
                    empty: true,
                    searchField: 'referencia',
                    labelField: 'referencia',
                    maxItems: 10,
                    deselect: false,
                    multiple: false,
                    search: true
                });
            });
            function crear() {

                let url = "{{route('tickets.store')}}"
                fetch(url, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    body: JSON.stringify({
                        total: $('#total').val()
                    })
                })
                    .then(response => response.json())
                    .then(data => {
                        console.log(data);
                        $('#id').val(data.id);
                        $('#crear').modal('show');
                    });
            }

            function verDetalle(id) {
                let url = "{{route('tickets.show', ['id' => 'REEMPLAZAR_ID'])}}"
                url = url.replace('REEMPLAZAR_ID', id);

                fetch(url)
                    .then(response => response.json())
                    .then(data => {
                        console.log(data);
                    });
            }

            function agregarProducto() {
                let url = "{{route('tickets.addProducto')}}"
                fetch(url, {
                    method: 'PATCH',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    body: JSON.stringify({
                        id: $('#id').val(),
                        referencia: $('#referencia').val(),
                        cantidad: $('#cantidad').val()
                    })
                })
                    .then(response => response.json())
                    .then(data => {
                        console.log(data);
                        const table = $('#tabla-agregados').DataTable();
                        table.row.add([
                            data.id,
                            data.referencia,
                            data.nombre,
                            data.precio_publico,
                            data.cantidad,
                            `<button class="btn btn-danger" onclick="eliminarProducto(${data.id})">Eliminar</button>`
                        ]).draw(false);
                        /* Meterlo en la tabla de productos agregados y con accion de poder borrarlo*/
                        
                    });
            }

            function deleteTicket() {
                let id = $('#id').val();
                let url = "{{route('tickets.delete', ['id' => 'REEMPLAZAR_ID'])}}"
                url = url.replace('REEMPLAZAR_ID', id);

                fetch(url, {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                })
                    .then(response => response.json())
                    .then(data => {
                        console.log(data);
                        $('#crear').modal('show');
                    });
            }

            let tableAgregar = new DataTable('#tabla-agregados', {
                dom: 't',
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
                }
            });

            function total() {
                let url = "{{route('tickets.total')}}"
                fetch(url, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                })
                    .then(response => response.json())
                    .then(data => {
                        console.log(data);
                        $('#total-input').val(data);
                        $('#total').modal('show');
                    });
            }
        </script>
    @endpush
</x-app-layout>
