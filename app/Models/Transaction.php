<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_id', 
        'order_id', 
        'customer_name', 
        'customer_email', 
        'customer_phone', 
        'total_price', 
        'status'
    ];

    /**
     * Relasi ke model Event.
     * Satu transaksi memiliki/milik satu event.
     */
    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}