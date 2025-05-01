<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    public  function index()
    {
        $productos = Producto::all();

        return view('productos.index', compact('productos'));
    }

    public function store(Request $request)
    {
        // Validar los datos recibidos
        $request->validate([
            'referencia' => 'required|string|max:255',
            'nombre' => 'required|string|max:255',
            'precio' => 'required|numeric',
            'precio_publico' => 'required|numeric',
            'cantidad' => 'required|integer',
        ]);

        if($request->id != ''){
            $producto = Producto::find($request->id);;
        }else{
            if(Producto::where('referencia', $request->referencia)->exists()) {
                $producto = Producto::where('referencia', $request->referencia)->first();
            } else {
                $producto = new Producto();
            }
        }

        
        $producto->referencia = $request->referencia;
        $producto->nombre = $request->nombre;
        $producto->precio = $request->precio;
        $producto->precio_publico = $request->precio_publico;
        if($request->id != '') {
            $producto->cantidad = $request->cantidad; 
        } else {
            $producto->cantidad += $request->cantidad;
        }
        $producto->save();

        return redirect()->back();
    }

    public function destroy(Request $request, $id)
    {
        $producto = Producto::find($id);
        if ($producto) {
            $producto->delete();
        }

        return redirect()->back();
    }

    public function agregarStock(Request $request)
    {
        $producto = Producto::where('referencia', $request->referencia)->first();
        if ($producto) {
            $producto->cantidad += $request->cantidad;
            $producto->save();
        }

        return redirect()->back();
    }
}
