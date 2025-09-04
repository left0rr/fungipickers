<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\History;
use Illuminate\Http\Request;

class HistoryController extends Controller
{
    /**
     * Store history
     */
    public function store(Request $request)
    {
        //check if the mushroom is already in user history
        $mushroom = History::where([
            'mushroom_id' => $request->mushroom_id,
            'user_id' => $request->user()->id
        ])->first();

        if(!$mushroom) {
            History::create([
                'mushroom_id' => $request->mushroom_id,
                'user_id' => $request->user()->id
            ]);

            //return the response
            return UserResource::make($request->user());
        }else {
            return UserResource::make($request->user());
        }
    }
}
