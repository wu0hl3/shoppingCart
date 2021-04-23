<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';
    protected $fillable = ['title','description','img','sort','type_id','price'];

    public function productType()
    {
        return $this->belongsTo('App\ProductType','type_id','id');
    }

    public function product_imgs()
    {
        return $this->hasMany('App\ProductImg','product_id')->orderBy('sort', 'desc');
    }
}
