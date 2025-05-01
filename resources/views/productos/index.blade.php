<x-app-layout>
    @push('css')
        <link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.dataTables.css" />
    @endpush
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Productos') }}
        </h2>
    </x-slot>

    <div class="card">
        <div class="d-flex justify-content-between align-items-center p-2">
            <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('home')}}">Inicio</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Productos</li>
                </ol>
            </nav>
            <div class="d-flex gap-3">
                <button class="btn btn-primary" onclick="crearProducto()">Crear</button>
                <button onclick="agregarStock('')" class="btn btn-success">Agregar stock</button>
            </div>
        </div>
        <table id="tabla-traducida" class="display">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Referencia</th>
                    <th>Nombre</th>
                    <th>Precio</th>
                    <th>Precio Publico</th>
                    <th>Cantidad</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($productos as $producto)
                    <tr>
                        <td>{{ $producto->id }}</td>
                        <td>{{ $producto->referencia }}</td>
                        <td>{{ $producto->nombre }}</td>
                        <td>{{ $producto->precio }}</td>
                        <td>{{ $producto->precio_publico }}</td>
                        <td>{{ $producto->cantidad }}</td>
                        <td class="d-flex gap-3">
                            <button class="btn btn-info" onclick="editarProducto({{ $producto->id }}, '{{$producto->referencia}}' , '{{ $producto->nombre }}', {{ $producto->precio }}, {{ $producto->precio_publico }}, {{ $producto->cantidad }})">Editar</button>
                            <form action="{{ route('productos.destroy', $producto->id) }}" method="post">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger">Borrar</button>
                            </form>
                            <button onclick="agregarStock('{{$producto->referencia}}')" class="btn btn-success">Agregar</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="modal fade" id="crearProducto" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="crearProducto" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="modal-title fs-5" id="crearProducto">Crear producto</h2>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('productos.store') }}" method="POST">
                        @csrf
                        <input type="hidden" id="id" name="id" value="">
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700">Referencia</label>
                            <input id="referencia" type="text" name="referencia" class="block w-full border rounded-md" required>
                        </div>
            
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700">Nombre</label>
                            <input id="nombre" type="text" name="nombre" class="block w-full border rounded-md" required>
                        </div>
            
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700">Precio</label>
                            <input id="precio" type="number" step="0.01" name="precio" class="block w-full border rounded-md"
                                required>
                        </div>
            
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700">Precio Público</label>
                            <input id="precio_publico" type="number" step="0.01" name="precio_publico" class="block w-full border rounded-md" required>
                        </div>
            
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700">Cantidad</label>
                            <input id="cantidad" type="number" name="cantidad" class="block w-full border rounded-md" required>
                        </div>
            
                        <div class="mt-5 flex justify-end gap-3">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" aria-label="Close">
                                Cancelar
                            </button>
                            <button type="submit" class="btn btn-primary">
                                Guardar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="agregarStock" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="agregarStock" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="modal-title fs-5" id="agregarStock">Agregar stock</h2>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('productos.addStock') }}" method="POST">
                        @method('PATCH')
                        @csrf
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700">Referencia</label>
                            <input id="referencia" type="text" name="referencia" class="block w-full border rounded-md" required>
                        </div>
            
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700">Cantidad</label>
                            <input id="cantidad" type="number" name="cantidad" class="block w-full border rounded-md" required>
                        </div>
            
                        <div class="mt-5 flex justify-end gap-3">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" aria-label="Close">
                                Cancelar
                            </button>
                            <button type="submit" class="btn btn-primary">
                                Guardar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>





    @push('js')
        <script src="https://code.jquery.com/jquery-3.7.1.slim.js" integrity="sha256-UgvvN8vBkgO0luPSUl2s8TIlOSYRoGFAX4jlCIm9Adc=" crossorigin="anonymous"></script>
        <script src="https://cdn.datatables.net/2.2.2/js/dataTables.js"></script>
        <script>
            function crearProducto() {
                $('#crearProducto').modal('show');
                $('#crearProducto').find('#id').val('');
            }

            function editarProducto(id, referencia, nombre, precio, precioPublico, cantidad) {
                $('#crearProducto').modal('show');
                $('#crearProducto').find('#referencia').val(referencia);
                $('#crearProducto').find('#nombre').val(nombre);
                $('#crearProducto').find('#precio').val(precio);
                $('#crearProducto').find('#precio_publico').val(precioPublico);
                $('#crearProducto').find('#cantidad').val(cantidad);
                $('#crearProducto').find('#id').val(id);
            }

            function agregarStock(referencia) {
                $('#agregarStock').modal('show');
                $('#agregarStock').find('#referencia').val(referencia);
            }

            
        </script>
    @endpush
</x-app-layout>
