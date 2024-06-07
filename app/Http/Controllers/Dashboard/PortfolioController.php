<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Repositories\Eloquent\EloquentPortfolioRepository;
use Illuminate\Http\Request;

class PortfolioController extends Controller
{
    //
    protected $portfolioRepository;

    public function __construct(EloquentPortfolioRepository $portfolioRepository)
    {
        $this->portfolioRepository = $portfolioRepository;
    }

    public function index(Request $request)
    {
        // Retrieve filtered portfolios from the repository
        $portfolios = $this->portfolioRepository->filter($request->only(['title', 'description']));

        return view('portfolios.index', compact('portfolios'));
    }

    public function create()
    {
        return view('portfolios.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title.ar' => 'required|string|max:255',
            'description.ar' => 'required|string',
            'image_path' => 'image|max:2048',
        ]);

        $portfolio = $this->portfolioRepository->create($data);

        // Upload image
        if($request->HasFile('image_path'))
            $portfolio->addMedia($request->file('image_path'))->toMediaCollection('images');

        return redirect()->route('portfolios.index')->with('success', 'Portfolio created successfully.');
    }

    public function edit($id)
    {
        $portfolio = $this->portfolioRepository->find($id);

        return view('portfolios.edit', compact('portfolio'));
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'title.ar' => 'required|string|max:255',
            'description.ar' => 'required|string',
            'image_path' => 'image|max:2048',
        ]);

        $portfolio = $this->portfolioRepository->find($id);

        // Update portfolio attributes
        $portfolio->update($data);

        // If a new image is uploaded, add it to the media library
        if ($request->hasFile('image_path')) {
            $portfolio->clearMediaCollection('images');
            $portfolio->addMedia($request->file('image_path'))->toMediaCollection('images');
        }

        return redirect()->route('portfolios.index')->with('success', 'Portfolio updated successfully.');
    }

    public function destroy($id)
    {
        $this->portfolioRepository->delete($id);

        return redirect()->route('portfolios.index')->with('success', 'Portfolio deleted successfully.');
    }

    public function destroyImage($id)
    {
        $category = $this->portfolioRepository->find($id);

        $category->clearMediaCollection('images');

        return response()->json([
            'status' => 'success',
            'code' => 200,
            'message' => 'Image deleted successfully.'
        ]);
    }
}
