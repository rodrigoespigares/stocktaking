<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TicketProducto extends Model
{
    public $table = 'ticket_productos';

    protected $fillable = [
        'ticket_id',
        'producto_id',
        'cantidad',
    ];

    public function ticket(){
        return $this->belongsTo(Ticket::class);
    }

    public function producto(){
        return $this->belongsTo(Producto::class);
    }
}
