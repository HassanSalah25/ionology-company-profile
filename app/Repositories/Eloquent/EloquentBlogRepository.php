<?php
namespace App\Repositories\Eloquent;

use App\Models\Blog;
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
}
