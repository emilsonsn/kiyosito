<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CoinHistory extends Model
{

    public function user()
    {
        return $this->belongsTo(User::class)->withDefault([
            'username' => 'Usuário Removido',
        ]);
    }
}
