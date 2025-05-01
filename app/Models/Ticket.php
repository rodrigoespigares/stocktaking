<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ticket extends Model
{
    use HasFactory;
    use SoftDeletes;

    public $table = 'tickets';

    protected $fillable = [
        'total',
    ];

    public function productos(){
        return $this->hasMany(TicketProducto::class);
    }
}
