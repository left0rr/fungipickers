<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mushroom extends Model
{
    protected $fillable = ['name','description','image_path','qr_code_path'];
    protected $appends = [
        'mushroom_image'];
    public function positives()
    {
        return $this->hasMany(Positive::class);

    }
    public function negatives()
    {
        return $this->hasMany(Negative::class);

    }
    public function getMushroomImageAttribute()
    {
        return asset('storage/'.$this->attributes['image_path']);
    }
    //
}
