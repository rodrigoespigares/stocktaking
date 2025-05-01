<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Ticket;
use App\Models\TicketProducto;
use Exception;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    public function index()
    {
        $this->clearTicket();
        $tickets = Ticket::all();
        $productos = Producto::all();
        return view('tickets.index', compact('tickets', 'productos'));
    }

    public function delete(String $id)
    {
        $ticket = Ticket::find($id);
        try{
            $ticket->productos()->delete();
            $ticket->forceDelete();
        }catch(Exception $e){
            return response()->json(['error' => $e->getMessage()], 400);
        }

        return response()->json(['success' => 'Ticket eliminado']);
    }

    public function store(Request $request)
    {
        $ticket = new Ticket();
        $ticket->total = 0;
        $ticket->save();

        return response()->json($ticket);
    }

    public function show($id)
    {
        $ticket = Ticket::find($id);
        return response()->json($ticket);
    }

    public function agregarProducto(Request $request)
    {
        $ticket = Ticket::find($request->id);

        if( !$ticket ){
            return response()->json(['error' => 'Ticket no encontrado'], 404);
        }

        $producto = Producto::where('referencia', $request->referencia)->first();

        if( !$producto ){
            return response()->json(['error' => 'Producto no encontrado'], 404);
        }

        if( $producto->cantidad - $request->cantidad < 0 ){
            return response()->json(['error' => 'Cantidad insuficiente'], 400);
        }

        $producto->cantidad -= $request->cantidad;
        $producto->save();

        $ticket_producto = new TicketProducto();
        $ticket_producto->ticket_id = $ticket->id;
        $ticket_producto->producto_id = $producto->id;
        $ticket_producto->cantidad = $request->cantidad;
        $ticket_producto->precio_unitario = $producto->precio_publico;
        $ticket_producto->save();

        $ticket->total += $request->cantidad * $producto->precio_publico;
        $ticket->save();
        
        return response()->json($producto);
    }

    public function total()
    {
        $ticket = Ticket::where('created_at', '>=', now()->subDays(1))->sum('total');
        return response()->json($ticket);
    }

    public function clearTicket() {
        if(Ticket::where('total', 0)->exists()){
            Ticket::where('total', 0)->delete();
        }
    }
}
