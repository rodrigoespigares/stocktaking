<?php

use App\Http\Controllers\ProductoController;
use App\Http\Controllers\TicketController;
use App\Models\Producto;
use App\Models\Ticket;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    $stats['total_productos'] = Producto::count();
    $stats['ventas_dia'] = Ticket::where('created_at', '>=', now()->subDays(1))->count();
    return view('welcome', compact('stats'));
})->name('home');


Route::get('/productos', [ProductoController::class, 'index'])->name('productos');
Route::post('/productos', [ProductoController::class, 'store'])->name('productos.store');
Route::delete('/productos/{producto}', [ProductoController::class, 'destroy'])->name('productos.destroy');
Route::patch('/productos/agregarStock', [ProductoController::class, 'agregarStock'])->name('productos.addStock');


Route::get('/tickets', [TicketController::class, 'index'])->name('tickets');
Route::get('/tickets/{id}', [TicketController::class, 'show'])->name('tickets.show');
Route::patch('/tickets/agregarProducto', [TicketController::class, 'agregarProducto'])->name('tickets.addProducto');
Route::post('/tickets', [TicketController::class, 'store'])->name('tickets.store');
Route::delete('/tickets/{id}', [TicketController::class, 'delete'])->name('tickets.delete');
Route::post('/tickets/total', [TicketController::class, 'total'])->name('tickets.total');

// ->middleware(['auth', 'verified'])


/* Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
}); */

require __DIR__.'/auth.php';
