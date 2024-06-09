<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Repositories\Eloquent\EloquentPortfolioRepository;
use App\Sevices\SEOService;
use Illuminate\Http\Request;

class PortfolioController extends Controller
{
    //
    protected $portfolioRepository;
    protected $seoService;

    public function __construct(EloquentPortfolioRepository $portfolioRepository, SEOService $seoService)
    {
        $this->portfolioRepository = $portfolioRepository;
        $this->seoService = $seoService;
    }

    public function index(Request $request)
    {

        $data['title'] = 'All Portfolios';
        $data['parentPageTitle'] = 'Portfolios';

        // Retrieve filtered portfolios from the repository
        $portfolios = $this->portfolioRepository->filter($request->only(['title', 'description']));

        return view(view: 'dashboard.portfolios.index', data: $data, mergeData: compact('portfolios'));
    }

    public function create()
    {

        $data['title'] = 'Create Portfolios';
        $data['parentPageTitle'] = 'Portfolios';


        // Get all services to pass to the view
        $data['services'] = $this->portfolioRepository->getAllServices();

        return view(view: 'dashboard.portfolios.create', data: $data);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title.ar' => 'required|string|max:255',
            'description.ar' => 'required|string',
            'image' => 'image|max:2048',
        ]);

        $portfolio = $this->portfolioRepository->create($request->all());

        $this->seoService->createOrUpdate($request, $portfolio);

        // Upload image
        if($request->HasFile('image'))
            $portfolio->addMedia($request->file('image'))->toMediaCollection('images');

        return redirect()->route('dashboard.portfolios.index')->with('success', 'Portfolio created successfully.');
    }

    public function edit($id)
    {

        $data['title'] = 'Edit Portfolios';
        $data['parentPageTitle'] = 'Portfolios';


        // Get all services to pass to the view
        $data['services'] = $this->portfolioRepository->getAllServices();
        $portfolio = $this->portfolioRepository->find($id);

        return view('dashboard.portfolios.edit', $data, compact('portfolio'));
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'title.ar' => 'required|string|max:255',
            'description.ar' => 'required|string',
            'image' => 'image|max:2048',
        ]);

        $portfolio = $this->portfolioRepository->find($id);

        // Update portfolio attributes
        $portfolio->update($request->all());

        $this->seoService->createOrUpdate($request, $portfolio);

        // If a new image is uploaded, add it to the media library
        if ($request->hasFile('image_path')) {
            $portfolio->clearMediaCollection('images');
            $portfolio->addMedia($request->file('image_path'))->toMediaCollection('images');
        }

        return redirect()->route('dashboard.portfolios.index')->with('success', 'Portfolio updated successfully.');
    }

    public function destroy($id)
    {
        $this->portfolioRepository->delete($id);

        return redirect()->route('dashboard.portfolios.index')->with('success', 'Portfolio deleted successfully.');
    }

    public function destroyImage($id)
    {
        $category = $this->portfolioRepository->find($id);

        $category->clearMediaCollection('images');

        return response()->json([
            'status' => 'success',
            'message' => 'Language deleted successfully'
        ], 200);    }


    /**
     * Remove the specified blog Image from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function removeImage($id)
    {
        $service = $this->serviceRepository->find($id);

        $service->clearMediaCollection('images');

        return response()->json([
            'status' => 'success',
            'code' => 200,
            'message' => 'Image deleted successfully.'
        ]);
    }
}
