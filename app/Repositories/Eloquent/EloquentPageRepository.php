<?php
namespace App\Repositories\Eloquent;

use App\Models\Page;
use App\Repositories\Contracts\PageRepositoryInterface;

class EloquentPageRepository implements PageRepositoryInterface
{
    protected $model;

    public function __construct(Page $page)
    {
        $this->model = $page;
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
        $page = $this->model->find($id);
        if ($page) {
            $page->update($data);
            return $page;
        }
        return null;
    }

    public function delete($id)
    {
        $page = $this->model->find($id);
        if ($page) {
            $page->delete();
            return true;
        }
        return false;
    }
}
