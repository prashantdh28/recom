<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransparencyProductFile extends Model
{
    protected $guarded = [];

    public function account()
    {
        return $this->belongsTo(Account::class, 'account_config_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
