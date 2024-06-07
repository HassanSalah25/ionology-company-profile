<?php
namespace App\Repositories\Eloquent;

use App\Models\SEO;
use App\Repositories\Contracts\SEORepositoryInterface;

class EloquentSEORepository implements SEORepositoryInterface
{
    protected $model;

    public function __construct(SEO $seo)
    {
        $this->model = $seo;
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
        $seo = $this->model->find($id);
        if ($seo) {
            $seo->update($data);
            return $seo;
        }
        return null;
    }

    public function delete($id)
    {
        $seo = $this->model->find($id);
        if ($seo) {
            $seo->delete();
            return true;
        }
        return false;
    }
}
