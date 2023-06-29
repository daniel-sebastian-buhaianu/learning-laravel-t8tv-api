<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use App\Models\VideoCategory;

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
    public function store(Request $request)
    {
        Validator::make($request->all(), [
            'name' => 'required|unique:video_category|string|max:100'
        ], [
            'name.unique' => 'A video category with that name already exists.',
        ])->validate();

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
    public function update(Request $request, string $id)
    {
        Validator::make($request->all(), [
            'name' => 'required|unique:video_category|string|max:100'
        ], [
            'name.unique' => 'A video category with that name already exists.',
        ])->validate();
        
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
     * Search resource listings by name.
     */
    public function search(string $name)
    {
        return VideoCategory::where('name', 'like', '%'.$name.'%')->get();
    }
}
