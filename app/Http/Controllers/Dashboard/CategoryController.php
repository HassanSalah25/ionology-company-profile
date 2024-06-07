<?php

namespace App\Http\Controllers\Dashboard;

use App\Enum\CategoryType;
use App\Http\Controllers\Controller;
use App\Repositories\Eloquent\EloquentCategoryRepository;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Enum;

class CategoryController extends Controller
{
    //
    protected $categoryRepository;

    public function __construct(EloquentCategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * Display a listing of the blogs.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $filters = $request->only(['name', 'description', 'type']);

        // Retrieve filtered blog posts from the repository
        $categories = $this->categoryRepository->filter($filters);

        return view('categories.index', compact('categories', 'filters'));
    }

    /**
     * Show the form for creating a new blog.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('categories.create');
    }

    /**
     * Store a newly created blog in storage.
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
            'type' => ['required',new Enum(CategoryType::class)]
            // Add more validation rules as needed
        ]);

        $category = $this->categoryRepository->create($data);

        // Add image to the media library
        $category->addMedia($request->file('image'))->toMediaCollection('images');


        return redirect()->route('categories.index')->with('success', 'Category created successfully.');
    }

    /**
     * Show the form for editing the specified blog.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category = $this->categoryRepository->find($id);
        return view('categories.edit', compact('category'));
    }

    /**
     * Update the specified blog in storage.
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
            'type' => ['required',new Enum(CategoryType::class)]
            // Add more validation rules as needed
        ]);

        $category = $this->categoryRepository->find($id);

        // Update blog attributes
        $category->update($data);

        // If a new image is uploaded, add it to the media library
        if ($request->hasFile('image')) {
            $category->clearMediaCollection('images');
            $category->addMedia($request->file('image'))->toMediaCollection('images');
        }

        return redirect()->route('categories.index')->with('success', 'Category updated successfully.');
    }

    /**
     * Remove the specified blog from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->categoryRepository->delete($id);
        return redirect()->route('categoris.index')->with('success', 'Category deleted successfully.');
    }

    /**
     * Remove the specified blog Image from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroyImage($id)
    {
        $category = $this->categoryRepository->find($id);

        $category->clearMediaCollection('images');

        return response()->json([
            'status' => 'success',
            'code' => 200,
            'message' => 'Image deleted successfully.'
        ]);
    }


}
