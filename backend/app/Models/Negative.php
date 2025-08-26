<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Negative extends Model
{
    protected $fillable = ['name','description','mushroom_id'];
    public function mushroom()
    {
        return $this->belongsTo(Mushroom::class);

    }
    //
}
