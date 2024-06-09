<?php
namespace App\Repositories\Eloquent;

use App\Enum\CategoryType;
use App\Models\Category;
use App\Models\Service;
use App\Repositories\Contracts\ServiceRepositoryInterface;

class EloquentServiceRepository implements ServiceRepositoryInterface
{
    protected $model;

    public function __construct(Service $service)
    {
        $this->model = $service;
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
        $data['category_name'] = Category::find($data['category_id'])->name;
        return $this->model->create($data);
    }

    public function update($id, array $data)
    {
        $service = $this->model->find($id);
        if ($service) {
            $service->update($data);
            return $service;
        }
        return null;
    }

    public function delete($id)
    {
        $service = $this->model->find($id);
        if ($service) {
            $service->delete();
            return true;
        }
        return false;
    }

    public function filter(array $filters)
    {
        $query = Service::query();

        if (isset($filters['name'])) {
            $query->whereTranslation('name', 'like', '%' . $filters['title'] . '%');
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
        return Category::where('type',CategoryType::SERVICE)->get();
    }
}
