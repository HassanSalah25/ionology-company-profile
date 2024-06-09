<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Repositories\Eloquent\EloquentPageRepository;
use App\Sevices\SEOService;
use Illuminate\Http\Request;

class PageController extends Controller
{
    protected $pageRepository;
    protected $seoService;

    public function __construct(EloquentPageRepository $pageRepository, SEOService $seoService)
    {
        $this->pageRepository = $pageRepository;
        $this->seoService = $seoService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $pages = $this->pageRepository->all();
        return view('dashboard.pages.index', compact('pages'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('dashboard.pages.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255',
            'content' => 'required|string',
            'position' => 'required|string',
        ]);

        //create a new resource
        $page = $this->pageRepository->create($data);

        $this->seoService->createOrUpdate($request, $page);

        return redirect()->route('dashboard.pages.index');
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
        $page = $this->pageRepository->find($id);
        return view('dashboard.pages.edit', compact('page'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255',
            'content' => 'required|string',
            'position' => 'required|string',
        ]);

        //update the resource
        $page = $this->pageRepository->update($id, $data);

        $this->seoService->createOrUpdate($request, $page);

        return redirect()->route('dashboard.pages.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $this->pageRepository->delete($id);
        return redirect()->route('dashboard.pages.index');
    }
}
