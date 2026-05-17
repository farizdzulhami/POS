<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice',
        'customer_id',
        'user_id', // boleh null jika tidak ada login
        'total',
    ];

    /**
     * Relasi ke tabel customer
     * Setiap order dimiliki oleh satu customer
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    /**
     * Relasi ke tabel user (optional)
     * Bisa null karena tidak ada login
     */
    public function user()
    {
        return $this->belongsTo(User::class)->withDefault([
            'name' => 'Guest',
        ]);
    }

    /**
     * Relasi ke tabel order_items
     * Satu order bisa punya banyak item
     */
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Auto-generate invoice kalau belum diisi
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->invoice)) {
                $model->invoice = 'INV-' . now()->format('YmdHis') . '-' . rand(100, 999);
            }
        });
    }
}
