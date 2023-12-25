<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable =[
        'brand_id','name','slug','sku','description','image','quantity','price','is_visible','is_featured','type','puplished_at'
    ];

    public function brand():belongsTo{
        return $this->belongsTo(related:Brand::class);
       } 

       public function categories():belongsToMany{
        return $this->belongsToMany(related:Category::class)->withTimestamps();
       }
}
