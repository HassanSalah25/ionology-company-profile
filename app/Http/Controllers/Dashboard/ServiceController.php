<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Repositories\Eloquent\EloquentServiceRepository;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    //
    protected $serviceRepository;

    public function __construct(EloquentServiceRepository $serviceRepository)
    {
        $this->serviceRepository = $serviceRepository;
    }

    public function index(Request $request)
    {
        $filters = $request->only(['title', 'created_at', 'category_id']);

        // Retrieve filtered service posts from the repository
        $services = $this->serviceRepository->filter($filters);

        // Get all categories to pass to the view
        $categories = $this->serviceRepository->getAllCategories();

        return view('services.index', compact('services', 'filters', 'categories'));
    }

    /**
     * Show the form for creating a new service.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Get all categories to pass to the view
        $categories = $this->serviceRepository->getAllCategories();
        return view('services.create',compact('categories'));
    }

    /**
     * Store a newly created service in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name.ar' => 'required|string|max:255',
            'description.ar' => 'required|string',
            'image' => 'required|image|max:2048',
            'images.*' => 'image|max:2048',
            'category_id' => 'exists|categories,id'
            // Add more validation rules as needed
        ]);

        $service = $this->serviceRepository->create($data);

        // Add image to the media library
        $service->addMedia($request->file('image'))->toMediaCollection('images');

        if($request->file('images') && count($request->file('images')) > 0){
            foreach ($request->file('images') as $image)
                $service->addMedia($image)->toMediaCollection('images');
        }

        return redirect()->route('services.index')->with('success', 'Service created successfully.');
    }

    /**
     * Show the form for editing the specified service.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $service = $this->serviceRepository->find($id);
        // Get all categories to pass to the view
        $categories = $this->serviceRepository->getAllCategories();
        return view('services.edit', compact('service','categories'));
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

        // If a new image is uploaded, add it to the media library
        if ($request->hasFile('image')) {
            $service->clearMediaCollection('images');
            $service->addMedia($request->file('image'))->toMediaCollection('images');
        }

        if($request->file('images') && count($request->file('images')) > 0){
            foreach ($request->file('images') as $image)
                $service->addMedia($image)->toMediaCollection('images');
        }

        return redirect()->route('services.index')->with('success', 'Service updated successfully.');
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
        return redirect()->route('services.index')->with('success', 'Service deleted successfully.');
    }

    /**
     * Remove the specified service Image from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroyImage($id)
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
