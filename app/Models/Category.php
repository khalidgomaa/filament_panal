<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $fillable=[
        'name','slug','parent_id','is_available','description'
    ];

    public function parent():belongsTo{
        return $this->belongsTo(related:Category::class,foriegnKey:'parent_id');
       } 

       public function child():hasMany{
        return $this->hasMany(related:Category::class,foriegnKey:'parent_id');
       }

       public function product():belongsTo{
        return $this->belongsToMany(related:Product::class);
       } 
}
