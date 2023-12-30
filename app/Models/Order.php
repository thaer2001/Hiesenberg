<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $guarded=[];
    protected $fillable = [
        'pharmacist_id',
        'status',
        'payment_status',
    ];

    public function pharmacist()
    {
        return $this->belongsTo(Pharmacist::class);
    }

    public function drugs()
    {
        return $this->belongsToMany(Drug::class);
    }
}
