<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    use HasFactory;
    protected $fillable=[
'name','slug','url','primary_hex','is_available','description'
    ];

    
   public function brands(){
    return $this->hasMany(related:Product::class);
   } 
}
