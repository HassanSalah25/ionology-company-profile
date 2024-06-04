<?php
namespace App\Repositories\Eloquent;

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
}
