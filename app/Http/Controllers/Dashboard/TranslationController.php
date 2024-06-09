<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Translation;
use Illuminate\Http\Request;

class TranslationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $translations = Translation::all();
        $data['title'] = 'All Translations';
        $data['parentPageTitle'] = 'Translations';
        return view('dashboard.translations.index', $data, compact('translations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $data['title'] = 'Create Translations';
        $data['parentPageTitle'] = 'Translations';
        return view('dashboard.translations.create',$data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $data = $request->validate([
            'locale' => 'required|exists:languages,code',
            'key' => 'required|string|max:255',
            'value' => 'required|string',
        ]);

        // Create a new translation
        $translation = Translation::create($data);

        return redirect()->route('dashboard.translations.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        $data['title'] = 'Edit Translations';
        $data['parentPageTitle'] = 'Translations';
        $translation = Translation::findOrFail($id);
        return view('dashboard.translations.edit', $data, compact('translation'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $data = $request->validate([
            'locale' => 'required|exists:languages,code',
            'key' => 'required|string|max:255',
            'value' => 'required|string',
        ]);

        $translation = Translation::findOrFail($id);
        $translation->update($data);

        return redirect()->route('dashboard.translations.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $translation = Translation::findOrFail($id);
        $translation->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Language deleted successfully'
        ], 200);
    }
}
