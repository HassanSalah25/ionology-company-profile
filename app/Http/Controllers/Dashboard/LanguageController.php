<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Language;
use Illuminate\Http\Request;

class LanguageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $data['languages'] = Language::all();
        $data['title'] = 'General Settings';
        $data['parentPageTitle'] = 'Settings';
        return view('dashboard.languages.index', $data );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $data['title'] = 'Create Language';
        $data['parentPageTitle'] = 'Languages';
        return view('dashboard.languages.create',$data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:255',
            'flag' => 'required|image|max:2048',
            'is_rtl' => 'nullable'
        ]);

        if(!$request->has('is_rtl'))
            $data['is_rtl'] = 'off';
        // Create a new language
        $language = Language::create($data);

        // Add image to the media library
        $language->addMedia($request->file('flag'))->toMediaCollection('images');

        return redirect()->route('dashboard.languages.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        $data['title'] = 'Edit Language';
        $data['parentPageTitle'] = 'Languages';
        $language = Language::findOrFail($id);
        return view('dashboard.languages.edit', $data,compact('language'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:255',
            'is_rtl' => 'nullable'
        ]);
        $language = Language::find($id);
        if(!$request->has('is_rtl'))
            $data['is_rtl'] = 'off';
        // Create a new language
        $language->update($data);

        // update image to the media library
        if($request->hasFile('flag')){
            $language->clearMediaCollection('images');
            $language->addMedia($request->file('flag'))->toMediaCollection('images');
        }

        return redirect()->route('dashboard.languages.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $language = Language::findOrFail($id);
        $language->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'Language deleted successfully'
        ], 200);
    }

    public function removeImage($id)
    {
        $language = Language::find($id);

        $language->clearMediaCollection('images');

        return response()->json([
            'status' => 'success',
            'code' => 200,
            'message' => 'Image deleted successfully.'
        ]);
    }
}
