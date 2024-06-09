<?php

namespace App\Http\Controllers\Dashboard;

use App\Enum\CategoryType;
use App\Http\Controllers\Controller;
use App\Models\Language;
use App\Repositories\Eloquent\EloquentCategoryRepository;
use App\Sevices\SEOService;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Enum;

class BlogCategoryController extends Controller
{
    //
    protected $categoryRepository;

    public function __construct(EloquentCategoryRepository $categoryRepository, SEOService $seoService)
    {
        $this->categoryRepository = $categoryRepository;
        $this->seoService = $seoService;
    }

    /**
     * Display a listing of the blogs.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\View\View
     */
    public function index(Request $request)
    {

        $data['title'] = 'All Categories';
        $data['parentPageTitle'] = 'Categories';
        $data['route'] = 'blogs_categories';
        $filters = ['type' => CategoryType::BLOG->value];
        // Retrieve filtered blog posts from the repository
        $categories = $this->categoryRepository->filter($filters);

        return view('dashboard.categories.index', $data, compact('categories', 'filters'));
    }

    /**
     * Show the form for creating a new blog.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\View\View
     */
    public function create()
    {
        $data['title'] = 'Create Categories';
        $data['parentPageTitle'] = 'Categories';
        $data['route'] = 'blogs_categories';
        return view('dashboard.categories.create', $data);
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
            'name.en' => 'nullable|string',
            'description.en' => 'nullable|string',
            'image' => 'required|image|max:2048'
            // Add more validation rules as needed
        ]);

        $data['type'] = CategoryType::BLOG->value;

        $category = $this->categoryRepository->create($data);

        $this->seoService->createOrUpdate($request, $category);

        // Add image to the media library
        $category->addMedia($request->file('image'))->toMediaCollection('images');


        return redirect()->route('dashboard.blogs_categories.index')->with('success', 'Category created successfully.');
    }

    /**
     * Show the form for editing the specified blog.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\View\View
     */
    public function edit($id)
    {
        $category = $this->categoryRepository->find($id);
        $data['title'] = 'Edit Categories';
        $data['parentPageTitle'] = 'Categories';
        $data['route'] = 'blogs_categories';
        return view('dashboard.categories.edit', $data, compact('category'));
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
            'name.en' => 'nullable|string',
            'description.en' => 'nullable|string',
            // Add more validation rules as needed
        ]);

        $data['type'] = CategoryType::BLOG->value;

        $category = $this->categoryRepository->find($id);

        // Update blog attributes
        $category->update($data);

        $this->seoService->createOrUpdate($request, $category);

        // If a new image is uploaded, add it to the media library
        if ($request->hasFile('image')) {
            $category->clearMediaCollection('images');
            $category->addMedia($request->file('image'))->toMediaCollection('images');
        }

        return redirect()->route('dashboard.blogs_categories.index')->with('success', 'Category updated successfully.');
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
        return response()->json([
            'status' => 'success',
            'message' => 'Category deleted successfully'
        ], 200);
    }

    /**
     * Remove the specified blog Image from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function removeImage($id)
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
