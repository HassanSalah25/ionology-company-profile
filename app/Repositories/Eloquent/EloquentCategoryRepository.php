<?php
namespace App\Repositories\Eloquent;

use App\Models\Category;
use App\Repositories\Contracts\CategoryRepositoryInterface;

class EloquentCategoryRepository implements CategoryRepositoryInterface
{
    protected $model;

    public function __construct(Category $category)
    {
        $this->model = $category;
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
        $category = $this->model->find($id);
        if ($category) {
            $category->update($data);
            return $category;
        }
        return null;
    }

    public function delete($id)
    {
        $category = $this->model->find($id);
        if ($category) {
            $category->delete();
            return true;
        }
        return false;
    }

    public function filter(array $filters = [])
    {
        $query = Category::query();

        if (isset($filters['name'])) {
            $query->whereTranslation('name', 'like', '%' . $filters['name'] . '%');
        }

        if (isset($filters['description'])) {
            $query->whereTranslation('description', 'like', '%' . $filters['description'] . '%');
        }

        if (isset($filters['type'])) {
            $query->where('type',$filters['type']);
        }

        return $query->get();
    }

    public function getAllCategories()
    {
        return Category::all();
    }
}
