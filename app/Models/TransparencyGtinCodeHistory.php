<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransparencyGtinCodeHistory extends Model
{
    protected $guarded = [];

    public function transparencyProduct()
    {
        return $this->belongsTo(ProductList::class, 'transparency_product_id', 'id');
    }
}
