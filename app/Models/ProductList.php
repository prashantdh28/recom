<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductList extends Model
{
    protected $guarded = [];

    public function accountConfig()
    {
        return $this->belongsTo(Account::class, 'account_config_id', 'id');
    }
}
