<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddPositiveRequest;
use App\Http\Requests\UpdatePositiveRequest;
use App\Models\Positive;
use App\Models\Mushroom;
use Illuminate\Http\Request;

class PositiveController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.positives.index')->with([
            'positives' => Positive::with(['mushroom'])->latest()->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $mushrooms = Mushroom::all();
        return view('admin.positives.create')->with([
            'mushrooms' => $mushrooms
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AddPositiveRequest $request)
    {
        //
        if($request->validated()) {
            Positive::create($request->validated());
            return redirect()->route('admin.positives.index')->with([
                'success' => 'Positive added successfully'
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Positive $positive)
    {
        //
        abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Positive $positive)
    {
        //
        $mushrooms = mushroom::all();
        return view('admin.positives.edit')->with([
            'mushrooms' => $mushrooms,
            'positive' => $positive
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePositiveRequest $request, Positive $positive)
    {
        //
        if($request->validated()) {
            $positive->update($request->validated());
            return redirect()->route('admin.positives.index')->with([
                'success' => 'Positive updated successfully'
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Positive $positive)
    {
        //
        $positive->delete();
        return redirect()->route('admin.positives.index')->with([
            'success' => 'Positive deleted successfully'
        ]);
    }
}
