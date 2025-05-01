<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Inicio') }}
        </h2>
    </x-slot>

    <div class="card">
        <div class="card-body">
            <div class="d-flex w-100 justify-content-evenly">
                <div class="col-2">
                    <div class="card border-info">
                        <div class="card-body d-flex justify-content-evenly align-items-center">
                            <div>
                                <i class="fa-solid fa-boxes-stacked display-1 text-info"></i>
                            </div>
                            <div>
                                <h2 class="text-info fw-bold">
                                    {{ $stats['total_productos'] }}
                                </h2>
                                <p class="text-black-50">Productos total</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-2">
                    <div class="card border-success">
                        <div class="card-body d-flex justify-content-evenly align-items-center">
                            <div>
                                <i class="fa-solid fa-coins display-1 text-success"></i>
                            </div>
                            <div>
                                <h2 class="text-success fw-bold">
                                    {{ $stats['ventas_dia'] }}
                                </h2>
                                <p class="text-black-50">Ventas del día</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-2">
                    <div class="card border-warning">
                        <div class="card-body d-flex justify-content-evenly align-items-center">
                            <div>
                                <i class="fa-solid fa-boxes-stacked display-1 text-warning"></i>
                            </div>
                            <div>
                                <h2 class="text-warning fw-bold">
                                    {{ $stats['total_productos'] }}
                                </h2>
                                <p class="text-black-50">Productos</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
