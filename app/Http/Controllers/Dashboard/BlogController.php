<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Repositories\Eloquent\EloquentBlogRepository;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    //
    protected $blogRepository;

    public function __construct(EloquentBlogRepository $blogRepository)
    {
        $this->blogRepository = $blogRepository;
    }

    /**
     * Display a listing of the blogs.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $filters = $request->only(['title', 'created_at', 'category_id']);

        // Retrieve filtered blog posts from the repository
        $blogs = $this->blogRepository->filter($filters);

        // Get all categories to pass to the view
        $categories = $this->blogRepository->getAllCategories();

        return view('blogs.index', compact('blogs', 'filters', 'categories'));
    }

    /**
     * Show the form for creating a new blog.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Get all categories to pass to the view
        $categories = $this->blogRepository->getAllCategories();
        return view('blogs.create',compact('categories'));
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
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'image' => 'required|image|max:2048'
            // Add more validation rules as needed
        ]);

        $blog = $this->blogRepository->create($data);

        // Add image to the media library
        $blog->addMedia($request->file('image'))->toMediaCollection('images');


        return redirect()->route('blogs.index')->with('success', 'Blog created successfully.');
    }

    /**
     * Show the form for editing the specified blog.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $blog = $this->blogRepository->find($id);
        // Get all categories to pass to the view
        $categories = $this->blogRepository->getAllCategories();
        return view('blogs.edit', compact('blog','categories'));
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
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'image' => 'nullable|image|max:2048', // Assuming maximum file size is 2MB (2048 KB)
            // Add more validation rules as needed
        ]);

        $blog = $this->blogRepository->find($id);

        // Update blog attributes
        $blog->update($data);

        // If a new image is uploaded, add it to the media library
        if ($request->hasFile('image')) {
            $blog->clearMediaCollection('images');
            $blog->addMedia($request->file('image'))->toMediaCollection('images');
        }

        return redirect()->route('blogs.index')->with('success', 'Blog updated successfully.');
    }

    /**
     * Remove the specified blog from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->blogRepository->delete($id);
        return redirect()->route('blogs.index')->with('success', 'Blog deleted successfully.');
    }

    /**
     * Remove the specified blog Image from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroyImage($id)
    {
        $blog = $this->blogRepository->find($id);

        $blog->clearMediaCollection('images');

        return response()->json([
            'status' => 'success',
            'code' => 200,
            'message' => 'Image deleted successfully.'
        ]);
    }


}
