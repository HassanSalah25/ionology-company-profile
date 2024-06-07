<?php
namespace App\Repositories\Eloquent;

use App\Models\Portfolio;
use App\Repositories\Contracts\PortfolioRepositoryInterface;

class EloquentPortfolioRepository implements PortfolioRepositoryInterface
{
    protected $model;

    public function __construct(Portfolio $portfolio)
    {
        $this->model = $portfolio;
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
        $portfolio = $this->model->find($id);
        if ($portfolio) {
            $portfolio->update($data);
            return $portfolio;
        }
        return null;
    }

    public function delete($id)
    {
        $portfolio = $this->model->find($id);
        if ($portfolio) {
            $portfolio->delete();
            return true;
        }
        return false;
    }

    public function filter(array $filters = [])
    {
        $query = Portfolio::query();

        if (isset($filters['title'])) {
            $query->whereTranslation('title', 'like', '%' . $filters['title'] . '%');
        }
        //'description', 'address', 'phone', 'email'
        if (isset($filters['description'])) {
            $query->whereTranslation('description', 'like', '%' . $filters['description'] . '%');
        }

        return $query->get();
    }
}
