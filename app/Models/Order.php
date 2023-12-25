<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory,softDeletes;
    protected $fillable =[
        'customer_id','number','total_price','status','shipping_price','notes'
    ];

    public function customer():belongsTo{
        return $this->belongsTo(related:Customer::class);
       } 

       public function items():hasMany{
        return $this->hasMany(related:OrderItem::class);
       }
}