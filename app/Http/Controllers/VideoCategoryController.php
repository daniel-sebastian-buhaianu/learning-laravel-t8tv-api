<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\VideoCategory;
use App\Http\Requests\StoreVideoCategoryRequest;
use App\Http\Requests\UpdateVideoCategoryRequest;

class VideoCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return VideoCategory::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreVideoCategoryRequest $request)
    {
        return VideoCategory::create([
            'name' => $request->name
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return VideoCategory::find($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateVideoCategoryRequest $request, string $id)
    {
        $videoCategory = VideoCategory::find($id);
        $videoCategory->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name)
        ]);
        
        return $videoCategory;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        return VideoCategory::destroy($id);
    }

    /**
     * Search video category by name.
     */
    public function search(string $name)
    {
        return VideoCategory::where('name', 'like', '%'.$name.'%')->get();
    }
}
