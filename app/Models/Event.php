<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'title',
        'description',
        'date',
        'location',
        'price',
        'stock',
        'poster_path',
    ];

    /**
     * Relasi ke Category
     * Mengetahui event ini masuk kategori mana.
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * TAMBAHKAN INI: Relasi ke Transaction
     * Satu event bisa memiliki banyak transaksi (pembelian tiket).
     */
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}