<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductImg extends Model
{
    protected $table = 'product_imgs';
    protected $fillable = ['product_id','img','sort'];

}
