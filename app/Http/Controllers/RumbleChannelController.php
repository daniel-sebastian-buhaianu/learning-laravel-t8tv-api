<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\RumbleChannel;

class RumbleChannelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return RumbleChannel::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Validator::make($request->all(), [
            'url' => [
                'required',
                'unique:rumble_channel',
                'string',
                'max:255',
                'url',
                'active_url',
                'starts_with:https://rumble.com/c/,https://www.rumble.com/c/',
            ],
        ], [
            'url.unique' => 'A rumble channel with that url already exists.',
        ])->validate();

        $res = addRumbleChannelToDatabase(
            getRumbleChannelAboutData($request->url)['data']
        );

        if (true === $res['success'])
        {
            return $res['data'];
        }

        return [
            'message' => $res['error']
        ];
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return RumbleChannel::find($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        return RumbleChannel::destroy($id);
    }

    /**
     * Search resource listings by title.
     */
    public function search(string $title)
    {
        return RumbleChannel::where('title', 'like', '%'.$title.'%')->get();
    }
}
