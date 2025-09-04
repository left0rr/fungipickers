<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\MushroomResource;
use App\Models\Mushroom;
use Illuminate\Http\Request;

class MushroomController extends Controller
{
    /**
     * Find the mushroom by id
     */
    public function findMushroomById(Mushroom $mushroom)
    {
        return MushroomResource::make($mushroom);

    }
    public function findMushroomByName($name)
    {
        $mushroom = Mushroom::whereName($name)->first();
        if($mushroom)
        {
            return MushroomResource::make($mushroom);
        }else{
            abort(404);
        }
    }
}
