<?php
namespace App\Repositories\Eloquent;

use App\Enum\CategoryType;
use App\Models\Blog;
use App\Models\Category;
use App\Repositories\Contracts\BlogRepositoryInterface;

class EloquentBlogRepository implements BlogRepositoryInterface
{
    protected $model;

    public function __construct(Blog $blog)
    {
        $this->model = $blog;
    }

    public function all()
    {
        return $this->model->all();
    }

    public function find($id)
    {
        return $this->model->find($id);
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update($id, array $data)
    {
        $blog = $this->model->find($id);
        if ($blog) {
            $blog->update($data);
            return $blog;
        }
        return null;
    }

    public function delete($id)
    {
        $blog = $this->model->find($id);
        if ($blog) {
            $blog->delete();
            return true;
        }
        return false;
    }

    public function filter(array $filters)
    {
        $query = Blog::query();

        if (isset($filters['title'])) {
            $query->where('title', 'like', '%' . $filters['title'] . '%');
        }

        if (isset($filters['created_at'])) {
            $query->whereDate('created_at', $filters['created_at']);
        }

        if (isset($filters['category_id'])) {
            $query->whereHas('categories', function ($q) use ($filters) {
                $q->where('id', $filters['category_id']);
            });
        }

        return $query->get();
    }

    public function getAllCategories()
    {
        return Category::where('type',CategoryType::BLOG)->get();
    }
}
