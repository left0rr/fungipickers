<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class History extends Model
{
    //
    protected $fillable = ['mushroom_id','user_id'];
    public function mushroom()
    {
        return $this->belongsTo(Mushroom::class);

    }
    public function user()
    {
        return $this->belongsTo(User::class);

    }
}
