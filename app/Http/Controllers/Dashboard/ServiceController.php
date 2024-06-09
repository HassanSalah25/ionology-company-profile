<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Repositories\Eloquent\EloquentServiceRepository;
use App\Sevices\SEOService;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    //
    protected $serviceRepository;
    protected $seoService;

    public function __construct(EloquentServiceRepository $serviceRepository, SEOService $seoService)
    {
        $this->serviceRepository = $serviceRepository;
        $this->seoService = $seoService;
    }

    public function index(Request $request)
    {
        $data['title'] = 'All Services';
        $data['parentPageTitle'] = 'Services';

        $filters = $request->only(['title', 'created_at', 'category_id']);

        // Retrieve filtered service posts from the repository
        $services = $this->serviceRepository->filter($filters);

        // Get all categories to pass to the view
        $categories = $this->serviceRepository->getAllCategories();

        return view('dashboard.services.index', $data, compact('services', 'filters', 'categories'));
    }

    /**
     * Show the form for creating a new service.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\View\View
     */
    public function create()
    {
        // Get all categories to pass to the view
        $categories = $this->serviceRepository->getAllCategories();
        $data['title'] = 'Create Services';
        $data['parentPageTitle'] = 'Services';

        return view('dashboard.services.create', $data, compact('categories'));
    }

    /**
     * Store a newly created service in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name.ar' => 'required|string|max:255',
            'description.ar' => 'required|string',
            'image' => 'required|image|max:2048',
            'images.*' => 'image|max:2048',
            'category_id' => 'exists:categories,id'
            // Add more validation rules as needed
        ]);

        $service = $this->serviceRepository->create($request->all());

        $this->seoService->createOrUpdate($request, $service);
        // Add image to the media library
        $service->addMedia($request->file('image'))->toMediaCollection('images');

        if($request->file('images') && count($request->file('images')) > 0){
            foreach ($request->file('images') as $image)
                $service->addMedia($image)->toMediaCollection('images');
        }

        return redirect()->route('dashboard.services.index')->with('success', 'Service created successfully.');
    }

    /**
     * Show the form for editing the specified service.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\View\View
     */
    public function edit($id)
    {
        $data['title'] = 'Edit Services';
        $data['parentPageTitle'] = 'Services';
        $service = $this->serviceRepository->find($id);
        // Get all categories to pass to the view
        $categories = $this->serviceRepository->getAllCategories();
        return view('dashboard.services.edit', $data, compact('service','categories'));
    }

    /**
     * Update the specified service in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'name.ar' => 'required|string|max:255',
            'description.ar' => 'required|string',
            'image' => 'image|max:2048',
            'images.*' => 'image|max:2048',
            'category_id' => 'exists|categories,id'
            // Add more validation rules as needed
        ]);

        $service = $this->serviceRepository->find($id);

        // Update service attributes
        $service->update($data);
        $this->seoService->createOrUpdate($request, $service);

        // If a new image is uploaded, add it to the media library
        if ($request->hasFile('image')) {
            $service->clearMediaCollection('images');
            $service->addMedia($request->file('image'))->toMediaCollection('images');
        }

        if($request->file('images') && count($request->file('images')) > 0){
            foreach ($request->file('images') as $image)
                $service->addMedia($image)->toMediaCollection('images');
        }

        return redirect()->route('dashboard.services.index')->with('success', 'Service updated successfully.');
    }

    /**
     * Remove the specified service from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->serviceRepository->delete($id);
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
